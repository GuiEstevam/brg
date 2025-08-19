//Adicionar o pacote desta classe.

import javax.ws.rs.Path;
import javax.ws.rs.POST;
import javax.ws.rs.Consumes;
import javax.ws.rs.Produces;
import javax.ws.rs.HeaderParam;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;

 /* para que este import possa ser utilizado é preciso adicionar a dependencia dele no maven repository
 * https://mvnrepository.com/artifact/com.google.code.gson/gson basta selecionar a última versão, ou 
 * adicionar manualmente no projeto.
 */
import com.google.gson.Gson;
import com.google.gson.JsonSyntaxException;

/*
 * Remover este comentário e adicionar o pacote ao import abaixo caso necessário.
 * Para este modelo, este import é essencial para o funcionamento da serialização.
 *
 * import ResultUnified;
 */

/**
 * Classe de modelo de WebService.
 *
 * @author Dminer
 */
@Path("webservice") //O caminho de acesso a essa classe.
public class WebServiceModel {

    /**
     * Exemplo de função de webService.
     *
     * @param authorization HeaderParam com um tokem que autoriza a execução do
     * webService.
     * @param json Dados recebidos como resposta.
     * @return Mensagem de feedback podendo conter os erros no envio da resposta
     * ou a confirmação de recebimento dos dados.
     */
    @POST //Utilizado o metodo POST para a transição com Json.
    @Path("unifiedResponse") //O caminho para acessar esta função com o webService, o caminho final ficará "https://(...)/<nomeDoProjeto>/<configuração>/webservice/unifiedResponse" onde /webservice é o caminho determinado na classe e /unifiedResponse é o caminho na função.
    @Consumes(MediaType.APPLICATION_JSON) //Define o tipo de mídia que o webService pode receber, nesse caso utilizado json.
    @Produces(MediaType.APPLICATION_JSON) //Define o retorno como um objeto Json.
    public Response methodExample(@HeaderParam("authorization") String authorization, String json) {
        //Verifica se quem está tentando chamar o WebService possui autorização para isto, se não envia uma mensagem para que seja verificado a autorização de acesso.
        if (authorization == null || !authorization.equals("token")) {
            return Response.ok("ERRO - Tentativa de acesso não autorizada, por favor verifique o token de autorização.").build();
        }

        try {
            //Cria um novo objeto baseado nos dados recebidos pelo JSON.
            ResultUnified serializedResponse = new Gson().fromJson(json, ResultUnified.class);

            /* Com o json serializado basta agora utilizar o objeto para recuperar os dados.
             * No exemplo abaixo ele ele exibirá no console o objeto AnttResponse recuperado do objeto no index 0 do array ResultDVeiculos
             * sendo assim possível agora tratar todos os campos que são necessários em seu projeto que foram retornados pela resposta
             * da Dminer.
             */
            if (!serializedResponse.getResultsDVeiculos().isEmpty()) {
                System.out.print("\n=====================\n" + serializedResponse.getResultsDVeiculos().get(0).getAnttResponse().toString());
            }

            //Confirmação do recebimento dos dados, dentro do Response.ok() também pode-se ser passado um objeto no lugar da String para a construção de um Json na resposta.
            return Response.ok("Análise recebeda com sucesso.").build();

        } catch (JsonSyntaxException e) {
            //Caso não seja possível construir a classe porque o json recebido apresenta erro, retornará esta mensagem.
            return Response.ok("ERRO - JSON em formato incorreto, por favor verifique o arquivo de envio.").build();
        }
    }
}