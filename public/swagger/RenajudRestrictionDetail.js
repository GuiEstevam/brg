//Adicionar o pacote.

import java.util.List;

/* 
* Adicionar os pacotes das classes ao import caso necessário, todas as classes abaixo são necessárias para a serialização.

import RenajudRestriction;

 */

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class RenajudRestrictionDetail {

    private List<RenajudRestriction> restrictions;

    public List<RenajudRestriction> getRestrictions() {
        return restrictions;
    }

    public void setRestrictions(List<RenajudRestriction> restrictions) {
        this.restrictions = restrictions;
    }
}