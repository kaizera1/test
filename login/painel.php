<?php

include('protect.php');

$items = array(['image'=>'imgs/hamburgao.jpg', 'name'=> 'Hamburgão', 'preco'=>'5.30'],
        ['image'=>'imgs/paodebatata.jpg', 'name'=> 'Pão de Batata', 'preco'=>'4.00'],
        ['image'=>'imgs/paodequeijo.jpeg', 'name'=> 'Pão de Queijo', 'preco'=>'3.50'],
        ['image'=>'imgs/picole.jpeg', 'name'=> 'Picolé', 'preco'=>'6.00'],
        ['image'=>'imgs/suco.jpeg', 'name'=> 'Suco', 'preco'=>'4.25']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Painel</title>
    </head>
<style>
        
body {
    font-size: 20px;
    margin-bottom: 30px; /* Adiciona margem na parte inferior */
}

.produto {
    float: left;
    margin-right: 10px;
    padding: 5px;
}

.produto img {
    width: 200px;
    height: 190px;
    border-radius: 5px;
}

.itens, .nome_preco {
    height: auto;
    font-size: 16px;
}

/* Remove a propriedade position: absolute; */
.sair, .carrinho {
    text-align: center;
    clear: both; 
    margin-top: 20px;
}
      

</style>
<br>
<body>
    Bem vindo ao Carrinho, <?php echo $_SESSION['name'];?>! Esse é nosso cardápio
    <br>
</br>

<?php foreach ($items as $key => $value): ?>
<div class="produto">
    <img src="<?php echo $value['image']?>"/>
    <p><?php echo $value['name']?></p>
    <p2>R$ <?php echo $value['preco']?></p2>
<br>
</br>
    <a href="?adicionar=<?php echo $key ?>">Add ao carrinho</a>
</div>
<?php endforeach;?>

<?php
//se a url recebeu 'adicionar', ou seja, se o usuario clicou no botao, prossiga
    if(isset($_GET['adicionar'])){
//converte o parametro adicionar para um numero inteiro
        $idProduto = (int) $_GET['adicionar'];
//verifica se o indice existe no array para que o produto seja valido
        if(isset($items[$idProduto])){
//verifica se ele existe tambem na variavel carrinho
            if(isset($_SESSION['carrinho'][$idProduto])){
//adiciona a quantidade do item no carrinho
                $_SESSION['carrinho'][$idProduto]['quantidade']++;
            } else{
//adiciona o item ao carrinho 1 vez
                $_SESSION['carrinho'][$idProduto] = array
                ('quantidade'=>1,'name'
                =>$items[$idProduto]['name'],'preco'
                =>$items[$idProduto]['preco']);
            }
            echo '<script>alert("O item foi adicionado ao carrinho.");</script>';
        }
    }  
?>

<div class="carrinho">
    <br>
    <h2>Compra</h2>
    <p>
        <?php
//quantidade de itens no carrinho
if(isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
    $qt_itens = 0;
    foreach($_SESSION['carrinho'] as $key => $value){
        $qt_itens += $value['quantidade'];
    }
    echo $qt_itens;
} else {
    echo '0';
}
?>
        itens no carrinho</p>
        
    </div>
    <div class="produtos">
        <?php
// Verifica se a sessão do carrinho está definida e se não está vazia
if(isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
    //listando os itens adicionados
    foreach ($_SESSION['carrinho'] as $key => $value) {
        ?>
<div class="itens">
<a href="?remover=<?php echo $key ?>"><img src="https://cdn-icons-png.flaticon.com/512/126/126468.png" width="25px"></a>
    <div class="nome_preco">
        <h2><?php echo $value['name']?><h2>
        <?php $preco = $value['preco'] * $value['quantidade']; ?>
        <p>R$ <?php echo number_format($preco,2,',','.'); ?></p>
    </div>
    <p2><?php echo $value['quantidade']?></p2>
    <hr>
</div>
<?php
    }
} else {
    // Se o carrinho estiver vazio, exiba uma mensagem
    echo "<p>Nenhum item adicionado ao carrinho</p>";
}
?>

<?php
//remover do carrinho
if(isset($_GET['remover'])){
    $idProduto = (int) $_GET['remover'];
    if(isset($_SESSION['carrinho'][$idProduto])){
        unset($_SESSION['carrinho'][$idProduto]);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

//esvaziar carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar'])) {
    // Resetar a sessão do carrinho
    $_SESSION['carrinho'] = array();
    // Redirecionar para a mesma página para evitar reenvio do formulário
    header('Location: ' . $_SERVER['PHP_SELF']);
    // Encerrar a execução do script
    exit;
}
?>
</div>
    <div class="total">
        <h2>Total:<br><p1>R$
            
<?php
$total = 0;

// Verifica se a sessão do carrinho está definida e se não está vazia
if(isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
    foreach($_SESSION['carrinho'] as $key => $value) {
        $total += $value['preco'] * $value['quantidade'];
    }
    echo "Total: " . number_format($total, 2, ',', '.');
} else {
    echo "Nenhum item no carrinho";
}
?>
</p1></h2>


<form method="post">
    <button type="submit" name="finalizar">Finalizar</button>
</form>

</div>


<p class="sair">
    <a href="logout.php">Sair</a>
    </p>
</body>
</html>