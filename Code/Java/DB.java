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
  	// Connection Details
    String username = "root";
    String password = ""; // Password obscured for commit on GitHub
    String databaseIP = "167.99.80.198";
    
    // Database
    String database = "customer";
    
    // Tables
    String menuTable = "menu";
    String allergensTable = "Allergens";
    String dietaryRequirementsTable = "DietaryRequirements";
    String descriptionsTable = "Descriptions";
    String ingredientsAndCaloriesTable = "IngredientsAndCalories";
    
    // Data Text Files
    String menuFilePath = "menu.txt";
    String allergensFilePath = "Allergens.txt";
    String dietaryRequirementsFilePath = "DietaryRequirements.txt";
    String descriptionsFilePath = "Descriptions.txt";
    String ingredientsFilePath = "IngredientsAndCalories.txt";
    
    
    int insertedRows = 0;
    
    Connection connection = connectToDatabase(username, password, databaseIP, database);
    if (connection != null) {
      System.out.println("Successfully connected to mySQL Server");
    } else {
      System.out.println("Failed to connect to mySQL Server");
    }
    
    
    dropTable(connection, menuTable); // Drops the Menu table if it already exists in 'Customer' database before inserting data
    dropTable(connection, allergensTable); // Drops the Allergens table if it already exists in 'Customer' database before inserting data
    dropTable(connection, dietaryRequirementsTable); // Drops the DietaryRequirements table if it already exists in 'Customer' database before inserting data
    dropTable(connection, descriptionsTable); // Drops the descriptionsTable if it already exists in 'Customer' database before inserting data
    dropTable(connection, ingredientsAndCaloriesTable); // Drops the ingredientsAndCaloriesTable if it already exists in 'Customer' database before inserting data
    
    // Creates the Menu table with the attributes mentioned
    createTable(connection, 
        menuTable + "(ID int, Item varchar(65), Category varchar(25), Sub_Category varchar(25), Price float(4,2), ImagePath varchar(25), "
        + "PRIMARY KEY (ID));");
    
    // Creates the Allergens table with the attributes mentioned
    createTable(connection,
    		allergensTable + "(ID int, Item varchar(65), Allergens varchar(80), "
    				+ "PRIMARY KEY(ID));");
    
    // Creates the Dietary Requirements table with the attributes mentioned
    createTable(connection, 
        dietaryRequirementsTable + "(ID int, Item varchar(65), Vegetarian varchar(3), Vegan varchar(3), GlutenFree varchar(3), "
        		+ "ContainsEgg varchar(3), ContainsMilk varchar(3), ContainsPeanuts varchar(3), ContainsTreeNuts varchar(3), "
        		+ "ContainsCelery varchar(3), ContainsFish varchar(3), ContainsCrustaceans varchar(3), ContainsMolluscs varchar(3), "
        		+ "ContainsMustard varchar(3), ContainsSoya varchar(3), ContainsSulphites varchar(3), ContainsSesameSeeds varchar(3), "
        		+ "ContainsLupin varchar(3), PRIMARY KEY (ID));");
    
    // Creates the Description table with the attributes mentioned
    createTable(connection,
    		descriptionsTable + "(ID int, Item varchar(65), Description varchar(185), "
    		+ "PRIMARY KEY (ID));");
    
    // Creates the IngredientsAndCalories table with the attributes mentioned
    createTable(connection,
    		ingredientsAndCaloriesTable + "(ID int, Item varchar(65), Ingredients varchar(220), Calories varchar(4), "
    		+ "PRIMARY KEY (ID));");
    
    // Calls the insertIntoTable method, which inserts data into each column in the Menu table with an asterisk as the delimiter
    insertedRows = insertIntoTable(connection, menuTable, menuFilePath);
    System.out.println("Inserted " + insertedRows + " rows into '" + menuTable + "' table");
    System.out.println("");
    
    // Calls the insertIntoTable method, which inserts data into each column in the Allergens table with an asterisk as the delimiter
    insertedRows = insertIntoTable(connection, allergensTable, allergensFilePath);
    System.out.println("Inserted " + insertedRows + " rows into '" + allergensTable + "' table");
    System.out.println("");
    
    // Calls the insertIntoTable method, which inserts data into each column in the DietaryRequirements table with an asterisk as the delimiter
    insertedRows = insertIntoTable(connection, dietaryRequirementsTable, dietaryRequirementsFilePath);
    System.out.println("Inserted " + insertedRows + " rows into '" + dietaryRequirementsTable + "' table");
    System.out.println("");
    
    // Calls the insertIntoTable method, which inserts data into each column in the Descriptions table with an asterisk as the delimiter
    insertedRows = insertIntoTable(connection, descriptionsTable, descriptionsFilePath);
    System.out.println("Inserted "+ insertedRows + " rows into '" + descriptionsTable + "' table");
    System.out.println("");
    
    // Calls the insertIntoTable method, which inserts data into each column in the IngredientsAndCalories table with an asterisk as the delimiter
    insertedRows = insertIntoTable(connection, ingredientsAndCaloriesTable, ingredientsFilePath);
    System.out.println("Inserted " + insertedRows + " rows into '" + ingredientsAndCaloriesTable + "' table");
    System.out.println("");
    
    
    System.out.println("");
    System.out.println("----- Finished all tasks! ------");
  }
  
  // Method is responsible for connecting this Java program to our database
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
  
  // Method is responsible for dropping the table mentioned if it already exists before we re-create that table and/or insert data
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
  
  // Method is responsible for creating a table (the name of this table is passed to the method as 'String table') in our database
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
  
  // Method is responsible for inserting data into our table from a text file. It separates each column by an asterisk which is our delimiter
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
  
  // This method is responsible for querying and selecting data from a specific category. 
  // NOTE: Method only works for menu table, as this is the only table containing a 'Category' column
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