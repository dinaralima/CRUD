<?php
$dsn = 'mysql:host=localhost;dbname=test;charset=utf8;port:3306';
$db_user = 'root';
$db_pass = '';
try{
  $db = new PDO($dsn, $db_user, $db_pass);
  $query = $db->query('SELECT * FROM filme');
  $filmes = $query->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
  echo $e->getMessage();
  die();
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
                <a class="navbar-brand" href="#">Lista de Filmes</a>
                <a class="btn pull-right btn-outline-success" href="create.php" role="button">Criar novo</a>
            </nav>
        </header>

        <section>
            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>
                <?php 
                foreach ($filmes[0] as $key=>$value){
                    if ($key=="idioma_original_id")  echo "";
                    else if ($key=="duracao_da_locacao")  echo "<th scope='col'>loc.</th>";
                    else if ($key=="ano_de_lancamento")  echo "<th scope='col'>lanc.</th>";
                    else if ($key=="preco_da_locacao")  echo "<th scope='col'>preço</th>";
                    else if ($key=="duracao_do_filme")  echo "<th scope='col'>min</th>";
                    else if ($key=="custo_de_substituicao")  echo "<th scope='col'>custo</th>";
                    else if ($key=="idioma_id")  echo "<th scope='col'>idioma</th>";
                    else echo "<th scope='col'>".$key."</th>";
                }
                echo "<th scope='col'>Editar</th>";
                echo "<th scope='col'>Excluir</th>";
                ?>
                </tr>
                </thead>
                <tbody>
                <?php 
                foreach ($filmes as $filme){
                    echo "<tr>";
                    foreach ($filme as $key=>$value){
                       if ($key=="idioma_original_id") echo "";
                       else if ($key=="idioma_id"){
                        //Aqui estou buscando o nome do idioma, não fica muito pesado requisitar sempre assim?
                        try{
                            $query2 = $db->prepare('SELECT nome FROM idioma where idioma_id=:id');
                            $query2->execute([
                            ':id'=>$value
                            ]);
                            $idioma = $query2->fetchAll(PDO::FETCH_ASSOC);
                            echo "<td>".$idioma[0]["nome"]."</td>";
                          }catch(PDOException $e){
                            echo $e->getMessage();
                            die();
                          }
                       }
                       else echo "<td>".$value."</td>";
                    } 
                    echo "<td><a class='btn pull-right btn-info' href='update.php?id=".$filme['filme_id']."' role='button'><i class='fas fa-pencil-alt'></i></a></td>";         
                    echo "<td><a class='btn pull-right btn-danger' href='delete.php?id=".$filme['filme_id']."' role='button'><i class='fas fa-times'></i></a></td>";  
                    echo "</tr>";    
              
                }
                ?>
                </tbody>
                </table>
            </section>


      
		<!-- SCRIPTS DE JS PARA O BOOTSTRAP -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
  </html>
