//Adicionar o pacote.

import java.util.List;

/* 
* Adicionar os pacotes das classes ao import caso necessário, todas as classes abaixo são necessárias para a serialização.

import DataValidation;
import ProcessDetail;
import SpecialAnalysis;

 */

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class ResultUnifiedProcess {

    private DataValidation dataValidation;
    private String processResultMessage;
    private List<ProcessDetail> process;
    private SpecialAnalysis specialAnalysis;

    public DataValidation getDataValidation() {
        return dataValidation;
    }

    public void setDataValidation(DataValidation dataValidation) {
        this.dataValidation = dataValidation;
    }

    public String getProcessResultMessage() {
        return processResultMessage;
    }

    public void setProcessResultMessage(String processResultMessage) {
        this.processResultMessage = processResultMessage;
    }

    public List<ProcessDetail> getProcess() {
        return process;
    }

    public void setProcess(List<ProcessDetail> process) {
        this.process = process;
    }

    public SpecialAnalysis getSpecialAnalysis() {
        return specialAnalysis;
    }

    public void setSpecialAnalysis(SpecialAnalysis specialAnalysis) {
        this.specialAnalysis = specialAnalysis;
    }
}