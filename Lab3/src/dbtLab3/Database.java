package dbtLab3;

import java.sql.*;
import java.util.ArrayList;

/**
 * Database is a class that specifies the interface to the movie database. Uses
 * JDBC and the MySQL Connector/J driver.
 */
public class Database {
	/**
	 * The database connection.
	 */
	private Connection conn;

	/**
	 * Create the database interface object. Connection to the database is
	 * performed later.
	 */
	public Database() {
		conn = null;
	}

	/**
	 * Open a connection to the database, using the specified user name and
	 * password.
	 * 
	 * @param userName
	 *            The user name.
	 * @param password
	 *            The user's password.
	 * @return true if the connection succeeded, false if the supplied user name
	 *         and password were not recognized. Returns false also if the JDBC
	 *         driver isn't found.
	 */
	public boolean openConnection(String userName, String password) {
		try {
			Class.forName("com.mysql.jdbc.Driver");
			conn = DriverManager.getConnection(
					"jdbc:mysql://puccini.cs.lth.se/" + userName, userName,
					password);
		} catch (SQLException e) {
			e.printStackTrace();
			return false;
		} catch (ClassNotFoundException e) {
			e.printStackTrace();
			return false;
		}
		return true;
	}

	/**
	 * Close the connection to the database.
	 */
	public void closeConnection() {
		try {
			if (conn != null) {
				conn.close();
			}
		} catch (SQLException e) {
		}
		conn = null;
	}

	/**
	 * Check if the connection to the database has been established
	 * 
	 * @return true if the connection has been established
	 */
	public boolean isConnected() {
		return conn != null;
	}

	/* --- insert own code here --- */
	public ArrayList<String> getMovies() {
		String sql = "select mName from Movies";
		PreparedStatement ps = null;
		ArrayList<String> movies = new ArrayList<String>();
		try {
			ps = conn.prepareStatement(sql);
			ResultSet rs = ps.executeQuery();

			while (rs.next()) {
				movies.add(rs.getString("mName"));
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} finally {
			try {
				ps.close();
			} catch (SQLException e2) {
				// ... can do nothing if things go wrong here
			}
		}
		return movies;

	}

	public ArrayList<String> getDates(String movie) {
		String sql = "select sDate from Shows where mName=?";
		PreparedStatement ps = null;
		ArrayList<String> dates = new ArrayList<String>();
		try {
			ps = conn.prepareStatement(sql);
			ps.setString(1, movie);
			ResultSet rs = ps.executeQuery();
			while (rs.next()) {
				dates.add(rs.getString("sDate"));
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} finally {
			try {
				ps.close();
			} catch (SQLException e2) {
				// ... can do nothing if things go wrong here
			}
		}
		return dates;

	}

	public Performance getPerformance(String movie, String date) {

		String sql = "select sDate,mName,tName, (capacity-nbrBooked) as freeSeats from Shows natural join Theaters where sDate = ? and mName = ?";
		PreparedStatement ps = null;
		Performance p = null;
		try {
			ps = conn.prepareStatement(sql);
			ps.setString(1, date);
			ps.setString(2, movie);
			ResultSet rs = ps.executeQuery();
			rs.next();
			p = new Performance(rs.getString("sDate"), rs.getString("mName"),
					rs.getString("tName"), rs.getInt("freeSeats"));

		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} finally {
			try {
				ps.close();
			} catch (SQLException e2) {
				// ... can do nothing if things go wrong here
			}
		}
		return p;

	}

	public int bookSeat(String movieName, String date) {
		PreparedStatement ps = null;
		ResultSet rs = null;
		String freeSeatsSql = "select (capacity-nbrBooked) as freeSeats from Shows natural join Theaters where sDate = ? and mName = ? for update";
		try {
			conn.setAutoCommit(false);
			ps = conn.prepareStatement(freeSeatsSql);
			ps.setString(1, date);
			ps.setString(2, movieName);
			rs = ps.executeQuery();
			rs.next();
			if (Integer.parseInt(rs.getString("freeSeats")) <= 0)
				return -2; // No seats available
		} catch (SQLException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		} finally {
			try {
				ps.close();
			} catch (SQLException e2) {
				// ... can do nothing if things go wrong here
			}
		}

		String sql = "insert into Reservations(uName,sDate,mName) "
				+ "values(?, ?, ?)";
		try {
			ps = conn.prepareStatement(sql);
			ps.setString(1, CurrentUser.instance().getCurrentUserId());
			ps.setString(2, date);
			ps.setString(3, movieName);
			int nbrRows = ps.executeUpdate();
			if (nbrRows == 0){
				conn.rollback();
			}
		} catch (SQLException e) {
			e.printStackTrace();
			return -1; // User doesn't exist ...
		} finally {
			try {
				ps.close();
			} catch (SQLException e2) {
				// ... can do nothing if things go wrong here
			}
		}
		sql = "update Shows " + "set nbrBooked = nbrBooked+1 "
				+ "where mName = ? " + "and sDate = ?";
		try {
			ps = conn.prepareStatement(sql);
			ps.setString(1, movieName);
			ps.setString(2, date);
			ps.executeUpdate();
		} catch (SQLException e) {
			e.printStackTrace();
			return -3; // update error ...
		} finally {
			try {
				ps.close();
			} catch (SQLException e2) {
				// ... can do nothing if things go wrong here
			}
		}
		int n = 0;
		sql = "select last_insert_id() as last_id " + "from Reservations";
		try {
			ps = conn.prepareStatement(sql);
			rs = ps.executeQuery();
			rs.next();
			n = rs.getInt("last_id");
			conn.commit();
		} catch (SQLException e) {
			e.printStackTrace();
			// return 3;
		} finally {
			try {
				conn.setAutoCommit(true);
				ps.close();
			} catch (SQLException e2) {
				// ... can do nothing if things go wrong here
			}
		}
		return n;
	}

}
