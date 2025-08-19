//Adicionar o pacote.

import java.util.List;

/* 
* Adicionar os pacotes das classes ao import caso necessário, todas as classes abaixo são necessárias para a serialização.

import Suspension;

 */

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class SuspensionDetail {

    private List<Suspension> suspesions;

    public List<Suspension> getSuspesions() {
        return suspesions;
    }

    public void setSuspesions(List<Suspension> suspesions) {
        this.suspesions = suspesions;
    }
}