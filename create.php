<?php
$ultima_atualizacao = date("Y-m-d H:i:s", time()); 
  $dsn = 'mysql:host=localhost;dbname=test;charset=utf8;port:3306';
  $db_user = 'root';
  $db_pass = '';
  try{
    $db = new PDO($dsn, $db_user, $db_pass);
    $query = $db->query('SELECT * FROM idioma');
    $idiomas = $query->fetchAll(PDO::FETCH_ASSOC);
  }catch(PDOException $e){
    echo $e->getMessage();
    die();
  }

if($_POST){
    echo "<pre>";
var_dump($_POST);
echo "</pre>";
try{
    $db = new PDO($dsn, $db_user, $db_pass);
    $titulo = (isset($_POST['titulo'])?$_POST['titulo']:'');
    $descricao = (isset($_POST['descricao'])?$_POST['descricao']:'');
    $ano_lancamento = (isset($_POST['ano_de_lancamento'])?$_POST['ano_de_lancamento']:'');
    $idioma = (isset($_POST['idioma'])?$_POST['idioma']:'');
    $idioma_original = (isset($_POST['idioma_original'])?$_POST['idioma_original']:'');
    $duracao_locacao = (isset($_POST['duracao_da_locacao'])?$_POST['duracao_da_locacao']:'');
    $preco_locacao = (isset($_POST['preco_da__locacao'])?$_POST['preco_da_locacao']:'');
    $duracao_filme = (isset($_POST['duracao_do_filme'])?$_POST['duracao_do_filme']:'');
    $custo_subs = (isset($_POST['custo_de_substituicao'])?$_POST['custo_de_substituicao']:'');
    $classificacao = (isset($_POST['classificacao'])?$_POST['classificacao']:'');
    $recursos_especiais = (isset($_POST['recursos_especiais'])?$_POST['recursos_especiais']:'');
   //$ultima_atualizacao = date("Y-m-d H:i:s", time()); 
    var_dump($ultima_atualizacao);
    $query = $db->prepare('INSERT INTO filme (titulo, descricao, ano_de_lancamento, idioma_id, idioma_original_id, duracao_da_locacao,
    preco_da_locacao, duracao_do_filme, custo_de_substituicao, classificacao, recursos_especiais, ultima_atualizacao)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
    $query->execute([$titulo,$descricao,$ano_lancamento,$idioma,$idioma_original,$duracao_locacao,
    $preco_locacao,$duracao_filme,$custo_subs,$classificacao,$recursos_especiais,$ultima_atualizacao]);

    //este cadastro não funcionou corretamente, dizia que parâmetros não batiam, para seguir, fiz do modo antigo

    // $query = $db->prepare('INSERT INTO filme (titulo, descricao, ano_de_lancamento, idioma_id, idioma_original_id, duracao_da_locacao, 
    // preco_da_locacao, duracao_do_filme, custo_de_substituicao, classificacao, recursos_especiais, ultima_atualizacao)
    // VALUES(:titulo, :descricao, :ano_de_lancamento, :idioma_id, :idioma_original_id, :duracao_da_locacao, 
    // :preco_da_locacao, :duracao_do_filme, :custo_de_substituicao, :classificacao, :recursos_especiais, :ultima_atualizacao);');
    // $query->execute([
    //   ':titulo'=>$titulo,
    //   ':descricao'=>$descricao,
    //   ':ano_de_lancamento'=>$ano_lancamento,
    //   ':idioma_id'=>$idioma,
    //   ':idioma_original_id'=>$idioma_original,
    //   ':duracao_locacao'=>$duracao_locacao,
    //   ':preco_locacao'=>$preco_locacao,
    //   ':duracao_filme'=>$duracao_filme,
    //   ':custo_substituicao'=>$custo_subs,
    //   ':classificacao'=>$classificacao,
    //   ':recursos_especiais'=>$recursos_especiais,
    //   ':ultima_atualizacao'=>$ultima_atualizacao
    // ]);
    //dúvida, como eu faria caso não quisesse dar location no caso de erro?
    header('Location:read.php');
  }catch(PDOException $e){
    echo $e->getMessage();
    die();
  }
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
		<link href="css/style.css" rel="stylesheet">
		<title>Lista de Filmes</title>
	</head>
	<body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Cadastro de Filme</a>
                <a class="btn pull-right btn-outline-success" href="read.php" role="button">Ver lista de filmes</a>
            </nav>
        </header>

        <section class="cadastro">
            <div class="container">
            <form action="create.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" placeholder="Título" name="titulo" value="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="descricao">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição" value=""></textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="ano_de_lancamento">Ano de lançamento</label>
                        <input type="text" class="form-control" id="ano_de_lancamento" placeholder="Ano de Lançamento" name="ano_de_lancamento" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="idioma">Idioma</label>
                        <select id="idioma" name="idioma" class="form-control">
                        <?php foreach ($idiomas as $idioma) { ?>
                            <option value="<?php echo $idioma['idioma_id']; ?>"><?php echo $idioma['nome']; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="idioma_original">Idioma Original</label>
                        <select id="idioma_original" name="idioma_original" class="form-control">
                        <?php foreach ($idiomas as $idioma) { ?>
                            <option value="<?php echo $idioma['idioma_id']; ?>"><?php echo $idioma['nome']; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="duracao_da_locacao">Duração da Locação</label>
                        <input type="text" class="form-control" id="duracao_da_locacao" placeholder="Duração da Locação" name="duracao_da_locacao" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="preco_da_locacao">Preço da Locação</label>
                        <input type="text" class="form-control" id="preco_da_locacao" placeholder="Preço da Locação" name="preco_da_locacao" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="duracao_do_filme">Duração do Filme</label>
                        <input type="text" class="form-control" id="duracao_do_filme" placeholder="Duração do Filme" name="duracao_do_filme" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="custo_de_substituicao">Custo de Substituição</label>
                        <input type="text" class="form-control" id="custo_de_substituicao" placeholder="Custo de Substituição" name="custo_de_substituicao" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="classificacao">Classificação</label>
                        <input type="text" class="form-control" id="classificacao" placeholder="PG, G, R ou NC-17" name="classificacao" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="recursos_especiais">Recursos Especiais</label>
                        <input type="text" class="form-control" id="recursos_especiais" placeholder="Trailers, Commentaries, Deleted Scenes, Behind the Scenes" name="recursos_especiais" value="">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar Filme</button>
            </form>
            </div>
        </section>


      
		<!-- SCRIPTS DE JS PARA O BOOTSTRAP -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
  </html>
