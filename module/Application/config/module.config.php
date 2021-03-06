<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\WsContentController;

return [
	'router'          => [
		'routes' => [

			// main route
			'home' => [
				'type'          => 'Segment',
				'options'       => [
					'route'       => '/[:controller]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*'
					],
					'defaults'    => [
						'__NAMESPACE__' => 'Application\Controller',
						'controller'    => 'Project',
						'action'        => 'index',
					],
				],
				'may_terminate' => true,

				'child_routes' => [
					'action' => [
						'type'          => 'Segment',
						'options'       => [
							'route'       => '/[:action]',
							'constraints' => [
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							],
						],
						'may_terminate' => true,

						'child_routes' => [
							'id' => [
								'type'          => 'Segment',
								'options'       => [
									'route'       => '/:id',
									'constraints' => [
										'id' => '[0-9]+',
									],
								],
								'may_terminate' => true,
							],
						],
					],

					'id' => [
						'type'          => 'Segment',
						'options'       => [
							'route'       => '/:id',
							'constraints' => [
								'id' => '[0-9]+',
							],
						],
						'may_terminate' => true,
					],
				],
			],

			// web services
			'ws'   => [
				'type'    => 'Segment',
				'options' => [
					'route' => '/ws',
				],

				'child_routes' => [
					'content' => [
						'type'    => 'Segment',
						'options' => [
							'route'       => '/content/:action',
							'constraints' => [
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							],
							'defaults'    => [
								'controller' => WsContentController::class,
							],
						],
					]
				]
			],
		],
	],
	'service_manager' => [
		'abstract_factories' => [
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		],
	],
	'controllers'     => [
		'invokables' => [
			'Application\Controller\Project'     => Controller\ProjectController::class,
			'Application\Controller\About'       => Controller\AboutController::class,
			'Application\Controller\Transaction' => Controller\TransactionController::class,
			'Application\Controller\User'        => Controller\UserController::class,
			WsContentController::class           => WsContentController::class
		],
	],
	'view_manager'    => [
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map'             => [
			'layout/layout' => __DIR__.'/../view/layout/layout.phtml',
			'error/404'     => __DIR__.'/../view/error/404.phtml',
			'error/index'   => __DIR__.'/../view/error/index.phtml',
		],
		'template_path_stack'      => [
			__DIR__.'/../view',
		],
		'strategies'               => [
			'ViewJsonStrategy',
		],
	],
];
