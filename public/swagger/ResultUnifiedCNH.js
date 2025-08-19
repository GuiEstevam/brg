//Adicionar o pacote.

/* 
* Adicionar os pacotes das classes ao import caso necessário, todas as classes abaixo são necessárias para a serialização.

import InfractionDetail;
import SuspensionDetail;

 */

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class ResultUnifiedCNH {

    private String faceBase64;
    private Integer validationStatusDocumentImage;
    private Integer validationStatusCnh;
    private Integer validationStatusSecurityNumber;
    private Integer validationStatusUf;
    private String validationImageMessage;
    private String renachNumber;
    private String registerNumber;
    private String category;
    private String name;
    private String rgNumber;
    private String ufRg;
    private String emissorRg;
    private String cpf;
    private String birthDate;
    private String issuanceDate;
    private String firstLicenseDate;
    private String expiryDate;
    private String performsPaidActivity;
    private String moopCourse;
    private String localIssuance;
    private String observation;
    private String securityNumber;
    private String ordinance;
    private String restriction;
    private String mirrorNumber;
    private String totalPoints;
    private String statusCNHImage;
    private String statusMessageCNHImage;
    private String base64CNHImage;
    private InfractionDetail infractions;
    private SuspensionDetail suspensions;

    public String getFaceBase64() {
        return faceBase64;
    }

    public void setFaceBase64(String faceBase64) {
        this.faceBase64 = faceBase64;
    }

    public Integer getValidationStatusDocumentImage() {
        return validationStatusDocumentImage;
    }

    public void setValidationStatusDocumentImage(Integer validationStatusDocumentImage) {
        this.validationStatusDocumentImage = validationStatusDocumentImage;
    }

    public Integer getValidationStatusCnh() {
        return validationStatusCnh;
    }

    public void setValidationStatusCnh(Integer validationStatusCnh) {
        this.validationStatusCnh = validationStatusCnh;
    }

    public Integer getValidationStatusSecurityNumber() {
        return validationStatusSecurityNumber;
    }

    public void setValidationStatusSecurityNumber(Integer validationStatusSecurityNumber) {
        this.validationStatusSecurityNumber = validationStatusSecurityNumber;
    }

    public Integer getValidationStatusUf() {
        return validationStatusUf;
    }

    public void setValidationStatusUf(Integer validationStatusUf) {
        this.validationStatusUf = validationStatusUf;
    }

    public String getValidationImageMessage() {
        return validationImageMessage;
    }

    public void setValidationImageMessage(String validationImageMessage) {
        this.validationImageMessage = validationImageMessage;
    }

    public String getRenachNumber() {
        return renachNumber;
    }

    public void setRenachNumber(String renachNumber) {
        this.renachNumber = renachNumber;
    }

    public String getRegisterNumber() {
        return registerNumber;
    }

    public void setRegisterNumber(String registerNumber) {
        this.registerNumber = registerNumber;
    }

    public String getCategory() {
        return category;
    }

    public void setCategory(String category) {
        this.category = category;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getRgNumber() {
        return rgNumber;
    }

    public void setRgNumber(String rgNumber) {
        this.rgNumber = rgNumber;
    }

    public String getUfRg() {
        return ufRg;
    }

    public void setUfRg(String ufRg) {
        this.ufRg = ufRg;
    }

    public String getEmissorRg() {
        return emissorRg;
    }

    public void setEmissorRg(String emissorRg) {
        this.emissorRg = emissorRg;
    }

    public String getCpf() {
        return cpf;
    }

    public void setCpf(String cpf) {
        this.cpf = cpf;
    }

    public String getBirthDate() {
        return birthDate;
    }

    public void setBirthDate(String birthDate) {
        this.birthDate = birthDate;
    }

    public String getIssuanceDate() {
        return issuanceDate;
    }

    public void setIssuanceDate(String issuanceDate) {
        this.issuanceDate = issuanceDate;
    }

    public String getFirstLicenseDate() {
        return firstLicenseDate;
    }

    public void setFirstLicenseDate(String firstLicenseDate) {
        this.firstLicenseDate = firstLicenseDate;
    }

    public String getExpiryDate() {
        return expiryDate;
    }

    public void setExpiryDate(String expiryDate) {
        this.expiryDate = expiryDate;
    }

    public String getPerformsPaidActivity() {
        return performsPaidActivity;
    }

    public void setPerformsPaidActivity(String performsPaidActivity) {
        this.performsPaidActivity = performsPaidActivity;
    }

    public String getMoopCourse() {
        return moopCourse;
    }

    public void setMoopCourse(String moopCourse) {
        this.moopCourse = moopCourse;
    }

    public String getLocalIssuance() {
        return localIssuance;
    }

    public void setLocalIssuance(String localIssuance) {
        this.localIssuance = localIssuance;
    }

    public String getObservation() {
        return observation;
    }

    public void setObservation(String observation) {
        this.observation = observation;
    }

    public String getSecurityNumber() {
        return securityNumber;
    }

    public void setSecurityNumber(String securityNumber) {
        this.securityNumber = securityNumber;
    }

    public String getOrdinance() {
        return ordinance;
    }

    public void setOrdinance(String ordinance) {
        this.ordinance = ordinance;
    }

    public String getRestriction() {
        return restriction;
    }

    public void setRestriction(String restriction) {
        this.restriction = restriction;
    }

    public String getMirrorNumber() {
        return mirrorNumber;
    }

    public void setMirrorNumber(String mirrorNumber) {
        this.mirrorNumber = mirrorNumber;
    }

    public String getTotalPoints() {
        return totalPoints;
    }

    public void setTotalPoints(String totalPoints) {
        this.totalPoints = totalPoints;
    }

    public String getStatusCNHImage() {
        return statusCNHImage;
    }

    public void setStatusCNHImage(String statusCNHImage) {
        this.statusCNHImage = statusCNHImage;
    }

    public String getStatusMessageCNHImage() {
        return statusMessageCNHImage;
    }

    public void setStatusMessageCNHImage(String statusMessageCNHImage) {
        this.statusMessageCNHImage = statusMessageCNHImage;
    }

    public String getBase64CNHImage() {
        return base64CNHImage;
    }

    public void setBase64CNHImage(String base64CNHImage) {
        this.base64CNHImage = base64CNHImage;
    }

    public InfractionDetail getInfractions() {
        return infractions;
    }

    public void setInfractions(InfractionDetail infractions) {
        this.infractions = infractions;
    }

    public SuspensionDetail getSuspensions() {
        return suspensions;
    }

    public void setSuspensions(SuspensionDetail suspensions) {
        this.suspensions = suspensions;
    }
}