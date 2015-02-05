package dbtLab3;

public class Performance {
	private String sDate;
	private String mName;
	private String tName;
	private int freeSeats;
	public Performance(String sDate, String mName, String tName, int freeSeats){
		this.sDate = sDate;
		this.mName = mName;
		this.tName = tName;
		this.freeSeats = freeSeats;
	}
	public String getsDate() {
		return sDate;
	}
	public String getmName() {
		return mName;
	}
	public String gettName() {
		return tName;
	}
	public String getFreeSeats() {
		return Integer.toString(freeSeats);
	}
	
}
