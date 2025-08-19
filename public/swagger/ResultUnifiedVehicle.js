//Adicionar o pacote.

/* 
* Adicionar os pacotes das classes ao import caso necessário, todas as classes abaixo são necessárias para a serialização.

import OccurrenceDetail;
import TrafficTicketRestrictionDetail;
import RenajudRestrictionDetail;
import AnttResponse;

 */

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class ResultUnifiedVehicle {

    private String indexVehicle;
    private String plateVehicle;
    private String CRVNumber;
    private String manufactureYear;
    private String licensingYear;
    private String modelYear;
    private String gearBox;
    private String weightCapacity;
    private String passengerCapacity;
    private String chassi;
    private String cylinderCapacity;
    private String cmt;
    private String fuel;
    private String color;
    private String transferDate;
    private String licensingDate;
    private String lesseDocument;
    private String ownerDocument;
    private String securityDocument;
    private String validationDocument;
    private String vehicleSpecie;
    private String noticeOfSale;
    private String trafficTicketRestriction;
    private String recallRestriction;
    private String renajudRestriction;
    private String brandModel;
    private String mouting;
    private String motor;
    private String county;
    private String previousCounty;
    private String lesseeName;
    private String ownerName;
    private String bodyNumber;
    private String axisNumber;
    private String auxAxixNumber;
    private String grossTotalWeight;
    private String vehiclePlate;
    private String previousVehiclePlate;
    private String pontecy;
    private String origin;
    private String chassisMarkup;
    private String renavam;
    private String restriction;
    private String licensingStatus;
    private String situation;
    private String vehicleType;
    private String uf;
    private String previousUf;
    private String restriction1;
    private String restriction2;
    private String restriction3;
    private String restriction4;
    private String restriction5;
    private Integer validationStatusOwner;
    private Integer validationStatusRenavam;
    private Integer validationStatusUf;
    private Integer validationStatusDocumentImage;
    private Integer validationStatusChassi;
    private String statusVehicleImage;
    private String statusMessageVehicleImage;
    private String base64VehicleImage;
    private OccurrenceDetail occurrenceDetail;
    private TrafficTicketRestrictionDetail infractionDetail;
    private RenajudRestrictionDetail renajudDetail;
    private AnttResponse anttResponse;

    public String getIndexVehicle() {
        return indexVehicle;
    }

    public void setIndexVehicle(String indexVehicle) {
        this.indexVehicle = indexVehicle;
    }

    public String getPlateVehicle() {
        return plateVehicle;
    }

    public void setPlateVehicle(String plateVehicle) {
        this.plateVehicle = plateVehicle;
    }

    public String getCRVNumber() {
        return CRVNumber;
    }

    public void setCRVNumber(String CRVNumber) {
        this.CRVNumber = CRVNumber;
    }

    public String getManufactureYear() {
        return manufactureYear;
    }

    public void setManufactureYear(String manufactureYear) {
        this.manufactureYear = manufactureYear;
    }

    public String getLicensingYear() {
        return licensingYear;
    }

    public void setLicensingYear(String licensingYear) {
        this.licensingYear = licensingYear;
    }

    public String getModelYear() {
        return modelYear;
    }

    public void setModelYear(String modelYear) {
        this.modelYear = modelYear;
    }

    public String getGearBox() {
        return gearBox;
    }

    public void setGearBox(String gearBox) {
        this.gearBox = gearBox;
    }

    public String getWeightCapacity() {
        return weightCapacity;
    }

    public void setWeightCapacity(String weightCapacity) {
        this.weightCapacity = weightCapacity;
    }

    public String getPassengerCapacity() {
        return passengerCapacity;
    }

    public void setPassengerCapacity(String passengerCapacity) {
        this.passengerCapacity = passengerCapacity;
    }

    public String getChassi() {
        return chassi;
    }

    public void setChassi(String chassi) {
        this.chassi = chassi;
    }

    public String getCylinderCapacity() {
        return cylinderCapacity;
    }

    public void setCylinderCapacity(String cylinderCapacity) {
        this.cylinderCapacity = cylinderCapacity;
    }

    public String getCmt() {
        return cmt;
    }

    public void setCmt(String cmt) {
        this.cmt = cmt;
    }

    public String getFuel() {
        return fuel;
    }

    public void setFuel(String fuel) {
        this.fuel = fuel;
    }

    public String getColor() {
        return color;
    }

    public void setColor(String color) {
        this.color = color;
    }

    public String getTransferDate() {
        return transferDate;
    }

    public void setTransferDate(String transferDate) {
        this.transferDate = transferDate;
    }

    public String getLicensingDate() {
        return licensingDate;
    }

    public void setLicensingDate(String licensingDate) {
        this.licensingDate = licensingDate;
    }

    public String getLesseDocument() {
        return lesseDocument;
    }

    public void setLesseDocument(String lesseDocument) {
        this.lesseDocument = lesseDocument;
    }

    public String getOwnerDocument() {
        return ownerDocument;
    }

    public void setOwnerDocument(String ownerDocument) {
        this.ownerDocument = ownerDocument;
    }

    public String getSecurityDocument() {
        return securityDocument;
    }

    public void setSecurityDocument(String securityDocument) {
        this.securityDocument = securityDocument;
    }

    public String getValidationDocument() {
        return validationDocument;
    }

    public void setValidationDocument(String validationDocument) {
        this.validationDocument = validationDocument;
    }

    public String getVehicleSpecie() {
        return vehicleSpecie;
    }

    public void setVehicleSpecie(String vehicleSpecie) {
        this.vehicleSpecie = vehicleSpecie;
    }

    public String getNoticeOfSale() {
        return noticeOfSale;
    }

    public void setNoticeOfSale(String noticeOfSale) {
        this.noticeOfSale = noticeOfSale;
    }

    public String getTrafficTicketRestriction() {
        return trafficTicketRestriction;
    }

    public void setTrafficTicketRestriction(String trafficTicketRestriction) {
        this.trafficTicketRestriction = trafficTicketRestriction;
    }

    public String getRecallRestriction() {
        return recallRestriction;
    }

    public void setRecallRestriction(String recallRestriction) {
        this.recallRestriction = recallRestriction;
    }

    public String getRenajudRestriction() {
        return renajudRestriction;
    }

    public void setRenajudRestriction(String renajudRestriction) {
        this.renajudRestriction = renajudRestriction;
    }

    public String getBrandModel() {
        return brandModel;
    }

    public void setBrandModel(String brandModel) {
        this.brandModel = brandModel;
    }

    public String getMouting() {
        return mouting;
    }

    public void setMouting(String mouting) {
        this.mouting = mouting;
    }

    public String getMotor() {
        return motor;
    }

    public void setMotor(String motor) {
        this.motor = motor;
    }

    public String getCounty() {
        return county;
    }

    public void setCounty(String county) {
        this.county = county;
    }

    public String getPreviousCounty() {
        return previousCounty;
    }

    public void setPreviousCounty(String previousCounty) {
        this.previousCounty = previousCounty;
    }

    public String getLesseeName() {
        return lesseeName;
    }

    public void setLesseeName(String lesseeName) {
        this.lesseeName = lesseeName;
    }

    public String getOwnerName() {
        return ownerName;
    }

    public void setOwnerName(String ownerName) {
        this.ownerName = ownerName;
    }

    public String getBodyNumber() {
        return bodyNumber;
    }

    public void setBodyNumber(String bodyNumber) {
        this.bodyNumber = bodyNumber;
    }

    public String getAxisNumber() {
        return axisNumber;
    }

    public void setAxisNumber(String axisNumber) {
        this.axisNumber = axisNumber;
    }

    public String getAuxAxixNumber() {
        return auxAxixNumber;
    }

    public void setAuxAxixNumber(String auxAxixNumber) {
        this.auxAxixNumber = auxAxixNumber;
    }

    public String getGrossTotalWeight() {
        return grossTotalWeight;
    }

    public void setGrossTotalWeight(String grossTotalWeight) {
        this.grossTotalWeight = grossTotalWeight;
    }

    public String getVehiclePlate() {
        return vehiclePlate;
    }

    public void setVehiclePlate(String vehiclePlate) {
        this.vehiclePlate = vehiclePlate;
    }

    public String getPreviousVehiclePlate() {
        return previousVehiclePlate;
    }

    public void setPreviousVehiclePlate(String previousVehiclePlate) {
        this.previousVehiclePlate = previousVehiclePlate;
    }

    public String getPontecy() {
        return pontecy;
    }

    public void setPontecy(String pontecy) {
        this.pontecy = pontecy;
    }

    public String getOrigin() {
        return origin;
    }

    public void setOrigin(String origin) {
        this.origin = origin;
    }

    public String getChassisMarkup() {
        return chassisMarkup;
    }

    public void setChassisMarkup(String chassisMarkup) {
        this.chassisMarkup = chassisMarkup;
    }

    public String getRenavam() {
        return renavam;
    }

    public void setRenavam(String renavam) {
        this.renavam = renavam;
    }

    public String getRestriction() {
        return restriction;
    }

    public void setRestriction(String restriction) {
        this.restriction = restriction;
    }

    public String getLicensingStatus() {
        return licensingStatus;
    }

    public void setLicensingStatus(String licensingStatus) {
        this.licensingStatus = licensingStatus;
    }

    public String getSituation() {
        return situation;
    }

    public void setSituation(String situation) {
        this.situation = situation;
    }

    public String getVehicleType() {
        return vehicleType;
    }

    public void setVehicleType(String vehicleType) {
        this.vehicleType = vehicleType;
    }

    public String getUf() {
        return uf;
    }

    public void setUf(String uf) {
        this.uf = uf;
    }

    public String getPreviousUf() {
        return previousUf;
    }

    public void setPreviousUf(String previousUf) {
        this.previousUf = previousUf;
    }

    public String getRestriction1() {
        return restriction1;
    }

    public void setRestriction1(String restriction1) {
        this.restriction1 = restriction1;
    }

    public String getRestriction2() {
        return restriction2;
    }

    public void setRestriction2(String restriction2) {
        this.restriction2 = restriction2;
    }

    public String getRestriction3() {
        return restriction3;
    }

    public void setRestriction3(String restriction3) {
        this.restriction3 = restriction3;
    }

    public String getRestriction4() {
        return restriction4;
    }

    public void setRestriction4(String restriction4) {
        this.restriction4 = restriction4;
    }

    public String getRestriction5() {
        return restriction5;
    }

    public void setRestriction5(String restriction5) {
        this.restriction5 = restriction5;
    }

    public Integer getValidationStatusOwner() {
        return validationStatusOwner;
    }

    public void setValidationStatusOwner(Integer validationStatusOwner) {
        this.validationStatusOwner = validationStatusOwner;
    }

    public Integer getValidationStatusRenavam() {
        return validationStatusRenavam;
    }

    public void setValidationStatusRenavam(Integer validationStatusRenavam) {
        this.validationStatusRenavam = validationStatusRenavam;
    }

    public Integer getValidationStatusUf() {
        return validationStatusUf;
    }

    public void setValidationStatusUf(Integer validationStatusUf) {
        this.validationStatusUf = validationStatusUf;
    }

    public Integer getValidationStatusDocumentImage() {
        return validationStatusDocumentImage;
    }

    public void setValidationStatusDocumentImage(Integer validationStatusDocumentImage) {
        this.validationStatusDocumentImage = validationStatusDocumentImage;
    }

    public Integer getValidationStatusChassi() {
        return validationStatusChassi;
    }

    public void setValidationStatusChassi(Integer validationStatusChassi) {
        this.validationStatusChassi = validationStatusChassi;
    }

    public String getStatusVehicleImage() {
        return statusVehicleImage;
    }

    public void setStatusVehicleImage(String statusVehicleImage) {
        this.statusVehicleImage = statusVehicleImage;
    }

    public String getStatusMessageVehicleImage() {
        return statusMessageVehicleImage;
    }

    public void setStatusMessageVehicleImage(String statusMessageVehicleImage) {
        this.statusMessageVehicleImage = statusMessageVehicleImage;
    }

    public String getBase64VehicleImage() {
        return base64VehicleImage;
    }

    public void setBase64VehicleImage(String base64VehicleImage) {
        this.base64VehicleImage = base64VehicleImage;
    }

    public OccurrenceDetail getOccurrenceDetail() {
        return occurrenceDetail;
    }

    public void setOccurrenceDetail(OccurrenceDetail occurrenceDetail) {
        this.occurrenceDetail = occurrenceDetail;
    }

    public TrafficTicketRestrictionDetail getInfractionDetail() {
        return infractionDetail;
    }

    public void setInfractionDetail(TrafficTicketRestrictionDetail infractionDetail) {
        this.infractionDetail = infractionDetail;
    }

    public RenajudRestrictionDetail getRenajudDetail() {
        return renajudDetail;
    }

    public void setRenajudDetail(RenajudRestrictionDetail renajudDetail) {
        this.renajudDetail = renajudDetail;
    }

    public AnttResponse getAnttResponse() {
        return anttResponse;
    }

    public void setAnttResponse(AnttResponse anttResponse) {
        this.anttResponse = anttResponse;
    }
}