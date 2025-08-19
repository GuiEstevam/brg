//Adicionar o pacote.

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class Occurrence {

    private String occurrenceDate;
    private String occurrenceType;
    private String agencyUf;
    private String occurrenceNumber;
    private String agency;

    public String getOccurrenceDate() {
        return occurrenceDate;
    }

    public void setOccurrenceDate(String occurrenceDate) {
        this.occurrenceDate = occurrenceDate;
    }

    public String getOccurrenceType() {
        return occurrenceType;
    }

    public void setOccurrenceType(String occurrenceType) {
        this.occurrenceType = occurrenceType;
    }

    public String getAgencyUf() {
        return agencyUf;
    }

    public void setAgencyUf(String agencyUf) {
        this.agencyUf = agencyUf;
    }

    public String getOccurrenceNumber() {
        return occurrenceNumber;
    }

    public void setOccurrenceNumber(String occurrenceNumber) {
        this.occurrenceNumber = occurrenceNumber;
    }

    public String getAgency() {
        return agency;
    }

    public void setAgency(String agency) {
        this.agency = agency;
    }
}