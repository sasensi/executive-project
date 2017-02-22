<?php

namespace Application\Controller;

use Application\Model\AbstractTable;
use Application\Model\Paymentmethod;
use Application\Model\Transaction;
use Application\Model\TransactionTable;
use Application\Model\UserTable;
use Application\Util\FrenchDepartment;
use Application\Util\Hashtable;
use Application\Util\MultiArray;
use Zend\View\Model\ViewModel;

class TransactionController extends AbstractActionCustomController
{
	public function indexAction()
	{
		$user = UserController::getLoggedUser();

		/** @var TransactionTable $transactionTable */
		$transactionTable = $this->getTable('transaction');

		$transactions = $transactionTable->getAllFromUserId($user->id);
		$transactions->buffer();

		$projectsIds = MultiArray::getArrayOfValues($transactions, 'project_id');
		$projects    = $this->getTable('project')->selectFromIds($projectsIds);
		$projectsHt  = Hashtable::createFromObject($projects);

		$paymentMethods   = $this->getTable('paymentmethod')->select();
		$paymentMethodsHt = Hashtable::createFromObject($paymentMethods);

		return new ViewModel([
			'transactions'     => $transactions,
			'projectsHt'       => $projectsHt,
			'paymentMethodsHt' => $paymentMethodsHt,
		]);
	}

	public function detailAction()
	{
		$id = $this->params()->fromRoute('id');

		/** @var Transaction $transaction */
		$transaction = $this->getTable('transaction')->selectFirstById($id);

		$project = $this->getTable('project')->selectFirstById($transaction->project_id);

		$paymentMethod = $this->getTable('paymentmethod')->selectFirstById($transaction->paymentmethod_id);

		return new ViewModel([
			'transaction'   => $transaction,
			'project'       => $project,
			'paymentMethod' => $paymentMethod,
		]);
	}

	public function addAction()
	{
		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();

		$params          = $request->getQuery();
		$amount          = $params->get('amount');
		$projectId       = $params->get('projectId');
		$paymentMethodId = $params->get('paymentMethodId');
		$nowDate         = new \DateTime('now', new \DateTimeZone('Europe/Paris'));

		if ($amount < 1)
		{
			throw new \Exception('Invalid transaction amount: '.$amount);
		}

		// debug: create transaction before receiving payment confirmation
		$this->getTable('transaction')->insert([
			'amount'           => $amount,
			'paymentdate'      => $nowDate->format(AbstractTable::DATE_FORMAT),
			'user_id'          => UserController::getLoggedUser()->id,
			'project_id'       => $projectId,
			'paymentmethod_id' => $paymentMethodId,
		]);

		$project = $this->getTable('project')->selectFirstById($projectId);

		// paypal case
		if ($paymentMethodId === (string) Paymentmethod::PAYPAL)
		{

			// build URL
			$data                    = [];
			$data['cmd']             = '_donations';
			$data['business']        = 'asensi.samuel-seller@gmail.com';
			$data['amount']          = $amount;
			$data['currency_code']   = 'EUR';
			$data['item_name']       = 'Financement du project '.utf8_decode($project->title);
			$data['lc']              = 'fr_FR';
			$data['cbt']             = 'Revenir sur le site';
			$data['rm']              = 2;
			$data['notify_url']      = $this->url()->fromRoute('home/action', ['controller' => 'transaction', 'action' => 'paypal_callback'], ['force_canonical' => true]);
			$data['return']          = $this->url()->fromRoute('home/action/id', ['controller' => 'transaction', 'action' => 'payment_success', 'id' => $project->id], ['force_canonical' => true]);
			$data['cancel_return']   = $this->url()->fromRoute('home/action', ['controller' => 'transaction', 'action' => 'payment_cancel'], ['force_canonical' => true]);
			$data['projectId']       = $project->id;
			$data['paymentMethodId'] = $paymentMethodId;

			$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?'.http_build_query($data);
			return $this->redirect()->toUrl($url);
		}

		return $this->redirectToRoute('transaction', 'payment_success', $project->id);
	}

	public function paypalCallbackAction()
	{
		// todo: handle IPN handshake then create transaction
	}

	public function paymentSuccessAction()
	{
		$project = $this->getTable('project')->selectFirstById($this->params()->fromRoute('id'));

		return new ViewModel([
			'project' => $project
		]);
	}

	public function paymentCancelAction()
	{
		return new ViewModel();
	}

	public function analyseAction()
	{
		/** @var UserTable $userTable */
		$userTable        = $this->getTable('user');
		$sexResult        = $userTable->getFinancersSexsForPieChart('sex', 'count');
		$ageResult        = $userTable->getFinancersAgesForBarChart();
		$departmentResult = $userTable->getFinancersDepartmentsForMap();

		// convert data for display
		$sexPieData = [];
		foreach ($sexResult as $item)
		{
			$sexPieData[] = ['name' => $item['sex'] === 'M' ? 'Hommes' : 'Femmes', 'y' => (int) $item['count']];
		}

		$ageData = [];
		foreach ($ageResult as $item)
		{
			$ageData[] = [(int) $item['age'], (int) $item['count']];
		}

		$departmentData = [];
		foreach ($departmentResult as $item)
		{
			$departmentData[] = ['name' => FrenchDepartment::codeToName($item['code']), 'value' => (int) $item['count']];
		}

		return new ViewModel([
			'sexPieData'     => $sexPieData,
			'ageData'        => $ageData,
			'departmentData' => $departmentData,
		]);
	}
}