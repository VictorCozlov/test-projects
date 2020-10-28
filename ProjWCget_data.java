
package projwcget_data;

import java.io.BufferedWriter;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.io.Writer;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.HashSet;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;


public class ProjWCget_data {
    
    //get site info throuht link
    private static Document getInfoSite(String link) throws IOException{
        
        Document document = Jsoup.connect(link).timeout(0).get();
        return document;
    }
    
    //return foreign key of the last updated row
    private static Integer getFK(Connection conn) throws IOException, SQLException{
        
        Integer number = 0;
        ResultSet rs;
        Statement stmt = conn.createStatement();
            String query = "SELECT idPc FROM page_crawled ORDER BY idPc DESC LIMIT 1";
            rs = stmt.executeQuery(query);
            while ( rs.next() ) 
            number = rs.getInt("idPc");
        return number;
    }
    
    //add crawled link to database
    private static void PCaddToBD(Connection conn, String link) throws IOException, SQLException{
        
        Statement stmt = conn.createStatement();
            String query = "INSERT INTO page_crawled (PWlink) VALUES ('"+link+"')";
            stmt.executeUpdate(query);
    }
    
    //add links founded in text to database
    private static void PC_LinkaddToBD(Connection conn, String link, Integer fk) throws IOException, SQLException{
        
        Statement stmt = conn.createStatement();
        System.out.println(link);
        if(link.length()>110){
            link = link.substring(0, 110);
            while(!link.substring(link.length()-1, link.length()).equals("/")){
                link = link.substring(0, link.length()-1);
            }
            System.out.println("changedd:   "+link);
        }
            String query = "INSERT INTO links (textlink, id_pc) VALUES ('"+link+"', '"+fk+"')";
            stmt.executeUpdate(query);
    }
    
    // get text and write text to file and flename to database
    private static void Get_WriteText(Connection conn, String link, Integer fk) throws IOException, SQLException{
        
        Document doc = getInfoSite(link);
        Statement stmt = conn.createStatement();
        Writer writer = null;
        Document doc1 = Jsoup.parse(doc.toString());
        String text = doc1.body().text();
        try {
            writer = new BufferedWriter(new OutputStreamWriter(new FileOutputStream("Doc_file/file_"+fk+".txt"), "utf-8"));
            writer.write(text);
        } catch (IOException ex) {
          // report
        } finally {
           try {writer.close();
           } catch (Exception ex) {/*ignore*/}
        }
        String query4 = "INSERT INTO text (textinfo, id_pc) VALUES ('file_"+fk+".txt', '"+fk+"')";
            stmt.executeUpdate(query4);
    }
    
    //check link for zip and pdf
    private static boolean CheckLink(String link){
        HashSet<String> limits = new HashSet<String>();
        limits.add("zip");
        limits.add("pdf");
        limits.add("png");
        String end = link.substring(link.length() - 3, link.length());
        if(!limits.contains(end)){
            return true;
        }
        return false;
    }
    
    //clean tables
    private static void CleanTables(Connection conn) throws SQLException{
        Statement stmt = conn.createStatement();
        String sql = "truncate table links";
        String sql1 = "truncate table page_crawled";
        String sql2 = "truncate table text";
        stmt.executeUpdate(sql);
        stmt.executeUpdate(sql1);
        stmt.executeUpdate(sql2);
        
    }
    
    
    public static void main(String[] args) throws IOException, SQLException{
        
        //variables
        ArrayList<String> pageToVisit = new ArrayList<String>();
        HashSet<String> pageVisited = new HashSet<String>();
        Integer VisitSitesNumber = 20;
        Integer fk = 0;
        //String url = "http://mrbool.com/how-to-create-a-web-crawler-and-storing-data-using-java/28925";
        String url = "http://www.bbc.com/news";
        
        String urlDB = "jdbc:mysql://localhost:3306/web_crawling";
        String username = "root";
        String password = "12369VK";
        
        System.out.println("Loading driver...");
        try {
            Class.forName("com.mysql.jdbc.Driver");
            System.out.println("Driver loaded!");
        } catch (ClassNotFoundException e) {
            throw new IllegalStateException("Cannot find the driver in the classpath!", e);
        }
        
        System.out.println("Connecting database...");
        try (Connection conn = DriverManager.getConnection(urlDB, username, password)) {
            System.out.println("Database connected!");
            //clean tables
            CleanTables(conn);
            //write page crawled adress into table
            PCaddToBD(conn, url);
            
            //get foreign key of last inseres link
            fk = getFK(conn);
            
            Document doc = getInfoSite(url);
            
            //get links
            System.out.println(fk +"  /---------------------------------------------------------------------/");
            Elements links = doc.select("a[href]");
            for (Element link : links) {
                PC_LinkaddToBD(conn, link.attr("abs:href"), fk);
                //write link to list
                pageToVisit.add(link.attr("abs:href"));
                //write link visited
                pageVisited.add(url);
            }
            
            //parse for text
            Get_WriteText(conn, url, fk);
            
            //crawl
            for(int i = 0; i<(VisitSitesNumber-1); i++){
                
                String link = pageToVisit.get(i);
                
                if(!pageVisited.contains(link)/*&&CheckLink(link)*/){
                    pageVisited.add(link);
                    PCaddToBD(conn, link);
                    
                    fk = getFK(conn);
                    
                    doc = getInfoSite(link);  
                    
                    //get links
                    System.out.println(fk +"  /---------------------------------------------------------------------/");
                    links = doc.select("a[href]");
                    for (Element lnk : links) {
                        PC_LinkaddToBD(conn, lnk.attr("abs:href"), fk);
                        //write link to list
                        pageToVisit.add(lnk.attr("abs:href"));  
                    }
                    Get_WriteText(conn, link, fk);
                }
            }
        }
    }
    
}
