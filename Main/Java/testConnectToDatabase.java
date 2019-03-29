package testing;

import static org.junit.jupiter.api.Assertions.*;

import java.sql.DriverManager;
import java.sql.SQLException;

import org.junit.Before;
import org.junit.jupiter.api.Test;

import com.mysql.jdbc.Connection;

class testConnectToDatabase {
	java.sql.Connection connection = null;
	@Test
	void test() {
		try {
			Class.forName("com.mysql.jdbc.Driver");
		} catch (ClassNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		try {
			connection = DriverManager.getConnection("jdbc:mysql://" + "167.99.80.198" + "/" + "customer", "root", "teamproject5");
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		assertTrue(connection!=null);
	}

}
