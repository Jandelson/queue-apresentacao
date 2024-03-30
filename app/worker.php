<?php

$dsn = "mysql:host=db;port=3306;dbname=app;charset=utf8mb4";

$pdo =  new PDO($dsn, 'root', 'root');
$tableQueue = 'queue';

while (true) {
    echo "PHP Working...\n";
    try {
        $stmt = $pdo->prepare("SELECT * FROM $tableQueue limit 1");
        $stmt->execute();
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = 1;
        $queryToDelete = [];
        foreach ($result as $row) {
            $queryToDelete[] = $row['sql_query'];
            echo "executando query $count : " . $row['sql_query'] . PHP_EOL;
            $count++;
        }
        //deletando as querys já executas
        foreach ($queryToDelete as $queryDelete) {
            $stmt = $pdo->prepare("DELETE FROM $tableQueue WHERE sql_query = :sql_query");
            $stmt->bindParam(':sql_query', $queryDelete, PDO::PARAM_INT);        
            $stmt->execute();
            echo "Query executada e removida da fila com sucesso!" . PHP_EOL;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    sleep(5);
}