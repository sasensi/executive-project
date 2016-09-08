# create column
ALTER TABLE project ADD COLUMN transactionsum INT DEFAULT 0;

# init column values from existing data
UPDATE project p
  INNER JOIN
  (
    SELECT project_id, SUM(amount) 'sumu'
    FROM transaction
    GROUP BY project_id
  ) t ON p.id = t.project_id
SET p.transactionsum = t.sumu;

# create triggers
DELIMITER $$

CREATE TRIGGER project_transactionsum_increment AFTER INSERT ON transaction
FOR EACH ROW
  BEGIN
    UPDATE project
    SET transactionsum = transactionsum + NEW.amount
    WHERE id = NEW.project_id;
  END$$

CREATE TRIGGER project_transactionsum_decrement AFTER DELETE ON transaction
FOR EACH ROW
  BEGIN
    UPDATE project
    SET transactionsum = transactionsum - OLD.amount
    WHERE id = OLD.project_id;
  END$$

DELIMITER ;