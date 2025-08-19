//Adicionar o pacote.

import java.util.ArrayList;

/* 
* Adicionar os pacotes das classes ao import caso necessário, todas as classes abaixo são necessárias para a serialização.

import ResultUnifiedProcess;
import ResultUnifiedCNH;
import ResultUnifiedVehicle;

 */

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class ResultUnified {

    private Integer statusCode;
    private Long solicitationID;
    private ResultUnifiedProcess resultDProcesso;
    private ResultUnifiedCNH resultDCNH;
    private ArrayList<ResultUnifiedVehicle> resultsDVeiculos;

    public Integer getStatusCode() {
        return statusCode;
    }

    public void setStatusCode(Integer statusCode) {
        this.statusCode = statusCode;
    }

    public Long getSolicitationID() {
        return solicitationID;
    }

    public void setSolicitationID(Long solicitationID) {
        this.solicitationID = solicitationID;
    }

    public ResultUnifiedProcess getResultDProcesso() {
        return resultDProcesso;
    }

    public void setResultDProcesso(ResultUnifiedProcess resultDProcesso) {
        this.resultDProcesso = resultDProcesso;
    }

    public ResultUnifiedCNH getResultDCNH() {
        return resultDCNH;
    }

    public void setResultDCNH(ResultUnifiedCNH resultDCNH) {
        this.resultDCNH = resultDCNH;
    }

    public ArrayList<ResultUnifiedVehicle> getResultsDVeiculos() {
        return resultsDVeiculos;
    }

    public void setResultsDVeiculos(ArrayList<ResultUnifiedVehicle> resultsDVeiculos) {
        this.resultsDVeiculos = resultsDVeiculos;
    }
}