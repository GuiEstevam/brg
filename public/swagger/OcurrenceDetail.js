//Adicionar o pacote.

import java.util.List;

/* 
* Adicionar os pacotes das classes ao import caso necessário, todas as classes abaixo são necessárias para a serialização.

import Occurrence;

 */

/**
 * Classe modelo para serialização da resposta Json
 *
 * @author Dminer
 */
public class OccurrenceDetail {

    private List<Occurrence> occurrences;

    public List<Occurrence> getOccurrences() {
        return occurrences;
    }

    public void setOccurrences(List<Occurrence> occurrences) {
        this.occurrences = occurrences;
    }
}