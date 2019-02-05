import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

public class DB {

  //private static final String SQL_INSERT = null;

  public static void main(String[] args) {
    String username = "root";
    String password = "teamproject5";
    String databaseIP = "167.99.80.198";
    String database = "customer";
    String table = "menu";
    String menuFilePath = "menu.txt";
    String categoriesFilePath = "categories.txt";
    
    Connection connection = connectToDatabase(username, password, databaseIP, database);
    if (connection != null) {
      System.out.println("Successfully connected to mySQL Server");
    } else {
      System.out.println("Failed to connect to mySQL Server");
    }
    
    dropTable(connection, table);
    createTable(connection, 
        table + "(ID int, Item varchar(65), Category varchar(25), Sub_Category varchar(20), Price varchar(6), "
        		+ "PRIMARY KEY (ID));");
    int insertedRows = insertIntoTable(connection, table, menuFilePath);
    System.out.println("Inserted " + insertedRows + " rows into '" + table + "' table");
    System.out.println("");
    
    // This produces a list of food/drink items by category. Takes each category from the categories text file
    String currentLine;
    try {
    	BufferedReader reader = new BufferedReader(new FileReader("categories.txt"));
    	while ((currentLine = reader.readLine()) != null) {
    		selectCategory(connection, currentLine);
    		System.out.println("");
    	}
    	reader.close();
    } catch (IOException e) {
    	e.printStackTrace();
    	System.out.println("Could not read '" + categoriesFilePath + "' file, see output for details");
    }
    // Query ends here
    
    System.out.println("");
    System.out.println("----- Finished all tasks! ------");
  }
  
  public static Connection connectToDatabase(String username, String password, String databaseIP, String database) {
    Connection connection = null;
    
    try {
      Class.forName("com.mysql.jdbc.Driver");
      connection = DriverManager.getConnection("jdbc:mysql://" + databaseIP + "/" + database, 
          username, password);
    } catch (ClassNotFoundException e) {
      e.printStackTrace();
      System.out.println("Driver not found, see output for details");
    } catch (SQLException e) {
      e.printStackTrace();
      System.out.println("Unable to connect to database, see output for details");
    }
    
    return connection;
  }
  
  public static void dropTable(Connection connection, String table) {
    Statement statement = null;
    try {
      statement = connection.createStatement();
      String command = "DROP TABLE IF EXISTS " + table;
      statement.execute(command);
      System.out.println("Dropped '" + table + "' table successfully");
    } catch (SQLException e) {
      e.printStackTrace();
      System.out.println("Error dropping table, see output for details");
    } finally {
      if (statement != null) {
        try {
          statement.close();
        } catch (SQLException e) {
          e.printStackTrace();
          System.out.println("Failed to close statement, see output for details");
        }
      }
    }
  }
  
  public static void createTable(Connection connection, String table) {
    Statement statement = null;
    try {
      statement = connection.createStatement();
      String command = "CREATE TABLE " + table;
      statement.execute(command);
      System.out.println("Created '" + table + "' table successfully");
    } catch (SQLException e) {
      e.printStackTrace();
      System.out.println("Failed to create '" + table + "' table, see output for details");
    } finally {
      if (statement != null) {
        try {
          statement.close();
        } catch (SQLException e) {
          e.printStackTrace();
          System.out.println("Failed to close statement, see output for details");
        }
      }
    }
  }
  
  public static int insertIntoTable(Connection connection, String table, String filepath) {
    BufferedReader reader = null;
      int numberOfRows = 0;
      try {
        Statement st = connection.createStatement();
        String currentLine, brokenLine[], composedLine = "";
        reader = new BufferedReader(new FileReader(filepath));
        while ((currentLine = reader.readLine()) != null) {
          // Insert each line to the DB
          brokenLine = currentLine.split("\\*");
          composedLine = "INSERT INTO " + table + "  VALUES (";
          int i;
          for (i = 0; i < brokenLine.length - 1; i++) {
            composedLine += "'" + brokenLine[i] + "',";
          }
          composedLine += "'" + brokenLine[i] + "')";
          System.out.println(composedLine);
          st.executeUpdate(composedLine);
          numberOfRows++;
        }
      } catch (SQLException e) {
        e.printStackTrace();
        System.out.println("Failed to insert data into table '" + table + "', see output for details");
      } catch (IOException e) {
      	e.printStackTrace();
      	System.out.println("Failed to read file. Is file name different or in wrong path? See output for details");
  		} finally {
        try {
          if (reader != null)
            reader.close();
        } catch (IOException e) {
          e.printStackTrace();
        }
      }
      return numberOfRows;
    
  }
  
  public static void selectCategory (Connection connection, String category) {
    Statement statement = null;
    ResultSet resultSet = null;
    System.out.println("Selecting items belonging to category: " + category);
    try {
      statement = connection.createStatement();
      resultSet = statement.executeQuery("SELECT DISTINCT ID, Item, Category, Sub_Category, Price FROM menu WHERE "
          + "Category = '" + category + "';");
      
      while (resultSet.next()) {
        int id = resultSet.getInt("ID");
        String item = resultSet.getString("Item");
        String type = resultSet.getString("Category");
        String subType = resultSet.getString("Sub_Category");
        String price = resultSet.getString("Price");
        System.out.println(id + ", " + item + ", " + type + ", " + subType + ", " + price);
      }
    } catch (SQLException e) {
      e.printStackTrace();
      System.out.println("Failed to query/select items from category '" + category + "', see output for details");
    } finally {
      try {
        statement.close();
      } catch (SQLException e) {
        e.printStackTrace();
        System.out.println("Failed to close statement, see output for details");
      }
    }
  }
  
  /* Redundant Code - As of 24/01/2019
   * Add code which builds a string depending on what diets are pressed, eg: if vegetarian
   * and gluten free is pressed, the diet must be "Vegetarian GlutenFree". If the string is
   * equal to "Vegetarian GlutenFree" then a query must run which finds both vegetarian and
   * gluten free items.
   */
  /* public static void selectDiet (Connection connection, String diet, String yesOrNo) {
    Statement statement = null;
    ResultSet resultSet = null;
    System.out.println("Selecting items suitable for '" + diet + "' diet:");
    try {
      statement = connection.createStatement();
      resultSet = statement.executeQuery("SELECT DISTINCT ID, Item, Category, Price, " + diet + " FROM menu WHERE "
          + diet + " = '" + yesOrNo + "';");
      
      while (resultSet.next()) {
        int id = resultSet.getInt("ID");
        String item = resultSet.getString("Item");
        String type = resultSet.getString("Category");
        String price = resultSet.getString("Price");
        String selectedDiet = resultSet.getString(diet);
        System.out.println(id + ", " + item + ", " + type + ", " + price + ", " + diet + ": " + selectedDiet);
      }
    } catch (SQLException e) {
      e.printStackTrace();
      System.out.println("Failed to query/select items suitable for diet '" + diet + "', see output for details");
    } finally {
      try {
        statement.close();
      } catch (SQLException e) {
        e.printStackTrace();
        System.out.println("Failed to close statement, see output for details");
      }
    }
  } */

}