
//Adicionar o pacote.

import java.util.List;

/* 
* Adicionar os pacotes das classes ao import caso necessário, todas as classes abaixo são necessárias para a serialização.

import PartProcessDetail;
import PoliceDistrictData;
import Article;

 */

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class ProcessDetail {

    private String number;
    private String uf;
    private String date;
    private String area;
    private String classDescription;
    private String situation;
    private String districtProcess;
    private String court;
    private List<PartProcessDetail> parts;
    private List<String> subjects;
    private List<PoliceDistrictData> policeDistrictData;
    private List<Article> articles;

    public String getNumber() {
        return number;
    }

    public void setNumber(String number) {
        this.number = number;
    }

    public String getUf() {
        return uf;
    }

    public void setUf(String uf) {
        this.uf = uf;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getArea() {
        return area;
    }

    public void setArea(String area) {
        this.area = area;
    }

    public String getClassDescription() {
        return classDescription;
    }

    public void setClassDescription(String classDescription) {
        this.classDescription = classDescription;
    }

    public String getSituation() {
        return situation;
    }

    public void setSituation(String situation) {
        this.situation = situation;
    }

    public String getDistrictProcess() {
        return districtProcess;
    }

    public void setDistrictProcess(String districtProcess) {
        this.districtProcess = districtProcess;
    }

    public String getCourt() {
        return court;
    }

    public void setCourt(String court) {
        this.court = court;
    }

    public List<PartProcessDetail> getParts() {
        return parts;
    }

    public void setParts(List<PartProcessDetail> parts) {
        this.parts = parts;
    }

    public List<String> getSubjects() {
        return subjects;
    }

    public void setSubjects(List<String> subjects) {
        this.subjects = subjects;
    }

    public List<PoliceDistrictData> getPoliceDistrictData() {
        return policeDistrictData;
    }

    public void setPoliceDistrictData(List<PoliceDistrictData> policeDistrictData) {
        this.policeDistrictData = policeDistrictData;
    }

    public List<Article> getArticles() {
        return articles;
    }

    public void setArticles(List<Article> articles) {
        this.articles = articles;
    }
}