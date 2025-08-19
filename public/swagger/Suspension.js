//Adicionar o pacote.

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class Suspension {

    private String suspensionReason;
    private String suspesionProcess;
    private String suspensionDate;
    private String suspensionDeadlineDate;
    private String suspensionSituation;
    private String suspensionSituationRecicle;

    public String getSuspensionReason() {
        return suspensionReason;
    }

    public void setSuspensionReason(String suspensionReason) {
        this.suspensionReason = suspensionReason;
    }

    public String getSuspesionProcess() {
        return suspesionProcess;
    }

    public void setSuspesionProcess(String suspesionProcess) {
        this.suspesionProcess = suspesionProcess;
    }

    public String getSuspensionDate() {
        return suspensionDate;
    }

    public void setSuspensionDate(String suspensionDate) {
        this.suspensionDate = suspensionDate;
    }

    public String getSuspensionDeadlineDate() {
        return suspensionDeadlineDate;
    }

    public void setSuspensionDeadlineDate(String suspensionDeadlineDate) {
        this.suspensionDeadlineDate = suspensionDeadlineDate;
    }

    public String getSuspensionSituation() {
        return suspensionSituation;
    }

    public void setSuspensionSituation(String suspensionSituation) {
        this.suspensionSituation = suspensionSituation;
    }

    public String getSuspensionSituationRecicle() {
        return suspensionSituationRecicle;
    }

    public void setSuspensionSituationRecicle(String suspensionSituationRecicle) {
        this.suspensionSituationRecicle = suspensionSituationRecicle;
    }
}