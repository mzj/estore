# Doctrine Migration File Generated on 2012-02-13 20:02:25
# Migrating from 20120208215000 to 20120213204120

# Version 20120213203140
CREATE TABLE order (id INT AUTO_INCREMENT NOT NULL, garment_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_F52993989CDB257C (garment_id), PRIMARY KEY(id)) ENGINE = InnoDB;
ALTER TABLE order ADD CONSTRAINT FK_F52993989CDB257C FOREIGN KEY (garment_id) REFERENCES garment(id);

# Version 20120213204120
CREATE TABLE estore_order (id INT AUTO_INCREMENT NOT NULL, garment_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_29B4A91A9CDB257C (garment_id), PRIMARY KEY(id)) ENGINE = InnoDB;
ALTER TABLE estore_order ADD CONSTRAINT FK_29B4A91A9CDB257C FOREIGN KEY (garment_id) REFERENCES garment(id);
