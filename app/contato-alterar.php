<?php
require 'header.php';

require "conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if(empty($id)){
    ?>
    <div class="alert alert-danger" role="alert">
        <h4>Falha ao abrir formulário para edição.</h4>
        <p>ID está vazio.</p>
    </div>
<?php
    exit;
}

$sql = "SELECT nome, email, mensagem, DATE_FORMAT(datahora, '%d/%m/%Y %H:%i:%s') as datahora 
        FROM contato WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

$registroContato = $stmt->fetch();

if (!$registroContato) {
    ?>
    <div class="alert alert-danger" role="alert">
        <h4>Contato não encontrado.</h4>
        <p>Nenhum registro foi localizado com o ID informado.</p>
    </div>
    <?php
    exit;
}
?>

<div class="inicio">
    <div class="bg-light p-4 mb-4 rounded">
        <h1 class="text-center">Formulário para contato</h1>
    </div>

    <div class="row">
        <div class="col-8 offset-2">
            <form class="row g-3" action="destino-contato-alterar.php" method="POST">
                <input type="hidden" name="id" value="<?=$id?>">
                <div class="col-6">
                    <div class="mb-2">
                        <label for="nome">Nome:</label>
                        <input class="form-control" type="text" name="nome" id="nome" 
                        required autofocus value="<?=$registroContato["nome"]?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-2">
                        <label for="email">E-mail</label>
                        <input class="form-control" type="email" name="email" id="email" 
                        placeholder="Digite seu email" required value="<?=$registroContato["email"]?>">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-2">
                        <label for="email">Mensagem</label>
                        <textarea class="form-control" name="msg" id="msg" cols="30" rows="3" required><?=$registroContato["mensagem"]?></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-2">
                        <label for="email">Data/Hora</label>
                        <input class="form-control" type="text" name="datahora" id="datahora" disabled value="<?=$registroContato["datahora"]?>">
                    </div>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <button type="reset" class="btn btn-warning">Limpar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require 'footer.php'
?>