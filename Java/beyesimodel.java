package model;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.math.*;

public class beyesimodel {

	
	public static double pbad=0.0320;
	public static double pgood=0.968;
	
	//cellphone
	public static double[] plcellphonebad={0.5160,0.4840};
	public static double[] plcellphonegood={0.4522,0.5478};
	
	public static double pphonegood=0.5457;
	public static double pphonebad=0.4543;
	
	//hukou
	public static double[] plhukoubad={0.0504,0.9496};
	public static double[] plhukougood={0.04,0.96};
	
	public static double phukougood=0.9597;
	public static double phukoubad=0.0403;
	
	//shipin
	public static double[] plshipinbad={0.0907,0.9093};
	public static double[] plshipingood={0.0717,0.9283};
	
    public static double pshipingood=0.0723;
    public static double pshipingbad=0.9277;
    
    //xueli
    public static double[] plxuelibad={0.2298,0.7702};
    public static double[] plxueligood={0.3578,0.6422};
    
    public static double pxueligood=0.3537;
    public static double pxuelibad=0.6463;
    
    //zhengxin
    public static double[] plzhengxinbad={0.0449,0.9551};
    public static double[] plzhengxingood={0.0350,0.9650};
    
    public static double pzhengxingood=0.0353;   
    public static double pzhengxinbad=0.9647;
    
    //gender
    public static double[] plMFbad={0.7751,0.2249};
    public static double[] plMFgood={0.6891,0.3109};
    
    public static double pM=0.3109;
    public static double pF=0.3081;
    
   //pingji
    public static double[] pabcdef={0.0355,0.1083,0.3921,0.3906,0.0681,0.0053};
    public static double[] pabcdefbad={0.0193,0.0828,0.2813,0.4672,0.1332,0.0161};
    public static double[] pabcdefgood={0.0360,0.1091,0.3958,0.3881,0.0660,0.0050};
    
   
    //借款金额  
    public static double minbad=3961d;
    public static double stdbad=2424.9d;
    
    public static double mingood=3905d;
    public static double stdgood=2285d;
    
    //年龄
    
    public static double ageminbad=30.0919;
    public static double agestdbad=7.1271;
    
    public static double agemingood=29.1104;
    public static double agestdgood=6.6349;
    
    public double[] getmappos(double loan,double age,int cellphonetag,int hukoutag,int shipintag,int xuelitag, int zhengxintag,int gendertag,int pingjitag){
    	
    	//MAP
    	//坏账
    	double[] possibilities=new double[2];
    	double pbadgg=getpdfvalue(age, ageminbad, agestdbad)*getpdfvalue(loan,minbad,stdbad)*plcellphonebad[cellphonetag]*plhukoubad[hukoutag]*plshipinbad[shipintag]*plxuelibad[xuelitag]*plzhengxinbad[zhengxintag]*plMFbad[gendertag]*pabcdefbad[pingjitag];
    	double pgoodg=getpdfvalue(age,agemingood,agestdgood)*getpdfvalue(loan,mingood,stdgood)*plcellphonegood[cellphonetag]*plhukougood[hukoutag]*plshipingood[shipintag]*plxueligood[xuelitag]*plzhengxingood[zhengxintag]*plMFgood[gendertag]*pabcdefgood[pingjitag];
    	//System.out.println(pbadgg);
    	//System.out.println(pgoodg);
    	System.out.println("差值:"+(pgoodg-pbadgg));
    	/*if(pbadgg>=pgoodg){
    		return "bad";
    	}else{
    		return "good";
    	}*/
    	possibilities[0]=pbadgg;
    	possibilities[1]=pgoodg;
    	return possibilities;
    	
    	
    }
    
    
    public double getpdfvalue(double x,double min,double std){
    	double pdf=0;
    	double temp11=Math.pow(x-min, 2);
    	double temp111=Math.pow(std, 2);
    	//System.out.println(temp11+" "+temp111);
    	double temp1=-temp11/(2*temp111);
    	//System.out.println("temp1:"+temp1);
    	double temp2=Math.exp(temp1);
    	//System.out.println("temp2:"+temp2);
    	double temp3=1/Math.sqrt(2*Math.PI*Math.pow(std, 2));
    	return temp3*temp2;    	
    }
    
    
    public int renzhengconvert(String convert){
    	
    	if(convert.equals("未成功认证")){
    		
    		return 1;
    	}else{
    		return 0;
    	}
    	
    }
    public int genderconvert(String convert){
    	if(convert.equals("男")){	
    		return 0;
    	}else{
    		return 1;
    	}

    }
    public int pingjiconvert(String convert){
    	if(convert.equals("A")){
    		return 0;
    	}else if(convert.equals("B")){
    		return 1;
    	}else if(convert.equals("C")){
    		return 2;
    	}else if(convert.equals("D")){
    		return 3;
    	}else if(convert.equals("E")){
    		return 4;
    	}else if(convert.equals("F")){
    		return 5;
    	}
    	return -1;
    }
    public static BufferedReader getinput(String filepath) throws FileNotFoundException{
    	
    	FileInputStream inputstream = new FileInputStream(filepath); 
    	StringBuffer buffer= new StringBuffer();
    	String line;
    	BufferedReader bufferreader=new BufferedReader(new InputStreamReader(inputstream));
    	return bufferreader;
    }
    
    
    
    public static void main(String[] args) throws IOException{
    	
    	beyesimodel b1model=new beyesimodel();
    	
    	try {
			BufferedReader b1BufferedReader=beyesimodel.getinput("src\\data\\newLC1.csv");
			String tempString = b1BufferedReader.readLine();
			FileOutputStream fs = new FileOutputStream(new File("src\\data\\poster.csv"));
			PrintStream p = new PrintStream(fs);
		    while((tempString=b1BufferedReader.readLine())!=null){
					
					System.out.println(tempString);
					String[] inputarray=tempString.split(",");
					//double loan,double age,int cellphonetag,int hukoutag,int shipintag,int xuelitag, int zhengxintag,int gendertag,int pingjitag
					
					
					double[] poster=b1model.getmappos(Integer.parseInt(inputarray[1]), Integer.parseInt(inputarray[8]), b1model.renzhengconvert(inputarray[10]), b1model.renzhengconvert(inputarray[11]), b1model.renzhengconvert(inputarray[12]), b1model.renzhengconvert(inputarray[13]), b1model.renzhengconvert(inputarray[14]), b1model.genderconvert(inputarray[9]),b1model.pingjiconvert(inputarray[5]));
					String line=poster[0]+","+poster[1];
					p.println(line);
				}
		    p.close();
		
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
    	
    	
    	
    	
    	
    	
    
    }
    
    
    
    
   
	
}
