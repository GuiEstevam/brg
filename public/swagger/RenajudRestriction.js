//Adicionar o pacote.

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class RenajudRestriction {

    private String restriction;
    private String observation;
    private String tribunal;
    private String processNumber;
    private String blockType;
    private String failureType;
    private String situation;
    private String searchAndSeizure;
    private String judiciaryBody;
    private String complement;
    private String registerDateTime;

    public String getRestriction() {
        return restriction;
    }

    public void setRestriction(String restriction) {
        this.restriction = restriction;
    }

    public String getObservation() {
        return observation;
    }

    public void setObservation(String observation) {
        this.observation = observation;
    }

    public String getTribunal() {
        return tribunal;
    }

    public void setTribunal(String tribunal) {
        this.tribunal = tribunal;
    }

    public String getProcessNumber() {
        return processNumber;
    }

    public void setProcessNumber(String processNumber) {
        this.processNumber = processNumber;
    }

    public String getBlockType() {
        return blockType;
    }

    public void setBlockType(String blockType) {
        this.blockType = blockType;
    }

    public String getFailureType() {
        return failureType;
    }

    public void setFailureType(String failureType) {
        this.failureType = failureType;
    }

    public String getSituation() {
        return situation;
    }

    public void setSituation(String situation) {
        this.situation = situation;
    }

    public String getSearchAndSeizure() {
        return searchAndSeizure;
    }

    public void setSearchAndSeizure(String searchAndSeizure) {
        this.searchAndSeizure = searchAndSeizure;
    }

    public String getJudiciaryBody() {
        return judiciaryBody;
    }

    public void setJudiciaryBody(String judiciaryBody) {
        this.judiciaryBody = judiciaryBody;
    }

    public String getComplement() {
        return complement;
    }

    public void setComplement(String complement) {
        this.complement = complement;
    }

    public String getRegisterDateTime() {
        return registerDateTime;
    }

    public void setRegisterDateTime(String registerDateTime) {
        this.registerDateTime = registerDateTime;
    }
}