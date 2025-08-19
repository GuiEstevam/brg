//Adicionar o pacote.

import java.util.List;

/* 
* Adicionar os pacotes das classes ao import caso necessário, todas as classes abaixo são necessárias para a serialização.

import SpecialAnalysisResult;

 */

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class SpecialAnalysis {

    private String resultSpecialAnalysisMessage;
    private List<SpecialAnalysisResult> results;

    public String getResultSpecialAnalysisMessage() {
        return resultSpecialAnalysisMessage;
    }

    public void setResultSpecialAnalysisMessage(String resultSpecialAnalysisMessage) {
        this.resultSpecialAnalysisMessage = resultSpecialAnalysisMessage;
    }

    public List<SpecialAnalysisResult> getResults() {
        return results;
    }

    public void setResults(List<SpecialAnalysisResult> results) {
        this.results = results;
    }
}