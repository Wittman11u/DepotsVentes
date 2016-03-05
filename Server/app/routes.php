<?php


$app->get('/api/depots/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");

    $collection = (new MongoDB\Client)->depotsventes->depots;
    $depot = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($id)]);
    if ($depot) {
        $depot['_id'] = (String)$depot['_id'];
        $response = $response->write(json_encode($depot));
        $response = $response->withHeader('Content-Type', 'application/json');
    } else {
        $response = $response->withStatus(404, 'Depot inexistent');
    }

    return $response;
});


$app->get('/api/sells/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");

    $collection = (new MongoDB\Client)->depotsventes->sells;
    $sell = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($id)]);
    if ($sell) {
        $sell['_id'] = (String)$sell['_id'];
        $response = $response->write(json_encode($sell));
        $response = $response->withHeader('Content-Type', 'application/json');
    } else {
        $response = $response->withStatus(404, 'Depot inexistent');
    }

    return $response;
});


$app->post('/api/depots', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", '*');
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    if (!empty($params['name'])
        && !empty($params['firstname'])
        && !empty($params['email'])
        && !empty($params['address'])
        && !empty($params['phone'])
    ) {
        $collection = (new MongoDB\Client)->depotsventes->depots;
        $depot = $collection->findOne(['email' => $params['email']]);
        if (!$depot) {
            $result = $collection->insertOne(['name' => $params['name'],
                'firstname' => $params['firstname'],
                'email' => $params['email'],
                'address' => $params['address'],
                'phone' => $params['phone'],
                'products' => []]);
            $response = $response->withStatus(201, 'Product created');
            $response = $response->withHeader('Content-Type', 'application/json');
            $depot = $collection->findOne(['email' => $params['email']]);

            $depot['_id'] = (String)$depot['_id'];
            $response = $response->write(json_encode($depot));
        } else {
            $response = $response->withStatus(400, 'email already use');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});


$app->post('/api/sells', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");
    $collection = (new MongoDB\Client)->depotsventes->sells;
    $result = $collection->insertOne(['products' => []]);
    $response = $response->withStatus(201, 'Product created');
    $response = $response->withHeader('Content-Type', 'application/json');
    $response = $response->write(json_encode(["id" => (String)$result->getInsertedId()]));
    return $response;
});

//Permet d ajouter des produits dans un depots
$app->post('/api/depots/{id_depot}/products', function ($request, $response, $args) {
    $params = $request->getParsedBody();
    $id_depot = $args['id_depot'];
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");

    if (!empty($params['reference'])
        && !empty($params['price'])
        && !empty($params['desc'])
    ) {
        $collection = (new MongoDB\Client)->depotsventes->depots;
        if ($collection->findOne(['products.reference' => $params['reference']]) === null) {
            $collection->findOneAndUpdate(['_id' => new MongoDB\BSON\ObjectID($id_depot)], ['$push' =>
                ['products' => [
                    'reference' => $params['reference'],
                    'price' => $params['price'],
                    'desc' => $params['desc'],
                    'state' => 'stock'
                ]]]);
            $depot = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($id_depot)]);
            $depot['_id'] = (String)$depot['_id'];
            $response = $response->write(json_encode($depot));
            $response = $response->withHeader('Content-Type', 'application/json');
            $response = $response->withStatus(201, 'Product created');

        } else {
            $response = $response->withStatus(400, 'Reference already use');
        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');
    }
    return $response;
});

//Permet d ajouter des produits dans une vente
$app->post('/api/sells/{id_sell}/products', function ($request, $response, $args) {
    $params = $request->getParsedBody();
    $id_sell = $args['id_sell'];

    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "POST");

    if (!empty($params['reference'])) {

        $collection = (new MongoDB\Client)->depotsventes->depots;
        $depot = $collection->findOne(['products.reference' => $params['reference']]);
        $prod = null;
        foreach ($depot->products as $product) {
            if ($product["reference"] === $params['reference'] && $product["state"] === "stock") {
                $prod = $product;
            }
        }
        if ($prod !== null) {
            $collection = (new MongoDB\Client)->depotsventes->sells;
            if ($collection->findOne(['products.reference' => $params['reference']]) === null) {
                $collection->findOneAndUpdate(['_id' => new MongoDB\BSON\ObjectID($id_sell)], ['$push' =>
                    ['products' => [
                        'reference' => $prod['reference'],
                        'price' => $prod['price'],
                        'desc' => $prod['desc']
                    ]]]);

                $sell = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($id_sell)]);
                $sell['_id'] = (String)$sell['_id'];
                $response = $response->write(json_encode($sell));
                $response = $response->withHeader('Content-Type', 'application/json');
                $response = $response->withStatus(201, 'Product add to sell');
            } else {
                $response = $response->withStatus(400, 'Product selling');

            }
        } else {
            $response = $response->withStatus(400, 'Not in stock');

        }
    } else {
        $response = $response->withStatus(400, 'Invalid parameters');

    }

    return $response;
});

//Permet de recuperer les produits d un depots (non-implementer)
$app->get('/api/depots/{id_depot}/products', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $collection = (new MongoDB\Client)->depotsventes->depots;
    return $response;
});


//Permet de recup les produits d une vente (non-implementer)
$app->get('/api/sells/{id_sell}/products', function ($request, $response) {
    $params = $request->getParsedBody();
    $response = $response->withHeader("Access-Control-Allow-Origin", "*");
    $response = $response->withHeader("Access-Control-Allow-Headers", "Content-Type");
    $response = $response->withHeader("Access-Control-Allow-Methods", "GET");
    $collection = (new MongoDB\Client)->depotsventes->sells;
    return $response;
});