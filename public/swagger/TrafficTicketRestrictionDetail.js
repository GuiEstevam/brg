//Adicionar o pacote.

import java.util.List;

/* 
* Adicionar os pacotes das classes ao import caso necessário, todas as classes abaixo são necessárias para a serialização.

import Infraction; //Objeto de infração do veículo.

 */

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class TrafficTicketRestrictionDetail {

    private List<Infraction> infractions;

    public List<Infraction> getInfractions() {
        return infractions;
    }

    public void setInfractions(List<Infraction> infractions) {
        this.infractions = infractions;
    }
}