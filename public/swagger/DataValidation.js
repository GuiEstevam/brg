//Adicionar o pacote.

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class DataValidation {

    private String cpf;
    private String birthDate;
    private String name;
    private String rg;
    private String mother;
    private String deathFlag;

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

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getRg() {
        return rg;
    }

    public void setRg(String rg) {
        this.rg = rg;
    }

    public String getMother() {
        return mother;
    }

    public void setMother(String mother) {
        this.mother = mother;
    }

    public String getDeathFlag() {
        return deathFlag;
    }

    public void setDeathFlag(String deathFlag) {
        this.deathFlag = deathFlag;
    }
}