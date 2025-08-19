//Adicionar o pacote.

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class AnttResponse {

    private String resultFound;
    private String city;
    private String registrationDate;
    private String typeRntrc;
    private String transporterMessage;
    private String vehicleMessage;
    private String transporterName;
    private String rntrcNumber;
    private String anttSituation;
    private String vehicleAnttSituation;
    private String ufRntrc;

    public String getResultFound() {
        return resultFound;
    }

    public void setResultFound(String resultFound) {
        this.resultFound = resultFound;
    }

    public String getCity() {
        return city;
    }

    public void setCity(String city) {
        this.city = city;
    }

    public String getRegistrationDate() {
        return registrationDate;
    }

    public void setRegistrationDate(String registrationDate) {
        this.registrationDate = registrationDate;
    }

    public String getTypeRntrc() {
        return typeRntrc;
    }

    public void setTypeRntrc(String typeRntrc) {
        this.typeRntrc = typeRntrc;
    }

    public String getTransporterMessage() {
        return transporterMessage;
    }

    public void setTransporterMessage(String transporterMessage) {
        this.transporterMessage = transporterMessage;
    }

    public String getVehicleMessage() {
        return vehicleMessage;
    }

    public void setVehicleMessage(String vehicleMessage) {
        this.vehicleMessage = vehicleMessage;
    }

    public String getTransporterName() {
        return transporterName;
    }

    public void setTransporterName(String transporterName) {
        this.transporterName = transporterName;
    }

    public String getRntrcNumber() {
        return rntrcNumber;
    }

    public void setRntrcNumber(String rntrcNumber) {
        this.rntrcNumber = rntrcNumber;
    }

    public String getAnttSituation() {
        return anttSituation;
    }

    public void setAnttSituation(String anttSituation) {
        this.anttSituation = anttSituation;
    }

    public String getVehicleAnttSituation() {
        return vehicleAnttSituation;
    }

    public void setVehicleAnttSituation(String vehicleAnttSituation) {
        this.vehicleAnttSituation = vehicleAnttSituation;
    }

    public String getUfRntrc() {
        return ufRntrc;
    }

    public void setUfRntrc(String ufRntrc) {
        this.ufRntrc = ufRntrc;
    }
}