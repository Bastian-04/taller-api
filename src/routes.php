<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    /* $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    }); */


        //Buscar cliente (todos)
    $app->get('/clientes', function ($request, $response, $args) {
       
        $sql = "SELECT * FROM tbl_cliente";

        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
                $payload = json_encode($clientes);
                $response->getBody()->write($payload);
                return $response
                    ->withHeader('Content-Type', 'application/json');
            } else {
                $payload = json_encode("No existen registros");
                $response->getBody()->write($payload);
                return $response
                    ->withHeader('Content-Type', 'application/json');
            }
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });


        //Buscar cliente (busqueda de un solo registro)
    $app->get('/cliente/{rut}', function ($request, $response, $args) {
        $rut = $args['rut'];
        $sql = "SELECT * FROM tbl_cliente WHERE rut_cliente='$rut'";

        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
                $payload = json_encode($clientes);
                $response->getBody()->write($payload);
                return $response
                ->withHeader('Content-Type', 'application/json');
        } else {
                $payload = json_encode("No existen registros");
                $response->getBody()->write($payload);
                return $response
                ->withHeader('Content-Type', 'application/json');
                }
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });

    //Agregar un nuevo cliente a la tabla
    $app->post('/cliente/nuevo', function ($request, $response, $args) {
        $rut_cliente    = $request->getParam('rut_cliente');
        $nombre         = $request->getParam('nombre');
        $apellido       = $request->getParam('apellido');
        $direccion      = $request->getParam('direccion');
        $telefono       = $request->getParam('telefono');
        $email          = $request->getParam('email');

        //Consulta
        $sql = "INSERT INTO tbl_cliente (rut_cliente,nombre,apellido,direccion,telefono,email) VALUES
                                        (:rut_cliente, :nombre, :apellido, :direccion, :telefono, :email)";
    
        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->prepare($sql);

            $resultado->bindParam(':rut_cliente', $rut_cliente);
            $resultado->bindParam(':nombre', $nombre);
            $resultado->bindParam(':apellido', $apellido);
            $resultado->bindParam(':direccion', $direccion);
            $resultado->bindParam(':telefono', $telefono);
            $resultado->bindParam(':email', $email);

            $resultado->execute();
                
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            $payload = json_encode($clientes);
            $response->getBody()->write($payload);
            return $response;
                
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });


    //MODIFICAR un registro
    $app->put('/cliente/modificar/{rut}', function ($request, $response, $args) {
        $rut = $args['rut'];
       
        $nombre         = $request->getParam('nombre');
        $apellido       = $request->getParam('apellido');
        $direccion      = $request->getParam('direccion');
        $telefono       = $request->getParam('telefono');
        $email          = $request->getParam('email');

        //$body = $request->getBody();
        //echo $body;
        //Consulta
        $sql = "UPDATE tbl_cliente SET
                
                apellido    = :apellido,
                nombre      = :nombre,
                direccion   = :direccion,
                telefono    = :telefono,
                email       = :email
                WHERE rut_cliente   = '$rut'";

        try{
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->prepare($sql);

            
            $resultado->bindParam(':nombre', $nombre);
            $resultado->bindParam(':apellido', $apellido);
            $resultado->bindParam(':direccion', $direccion);
            $resultado->bindParam(':telefono', $telefono);
            $resultado->bindParam(':email', $email);

            $resultado->execute();
            
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            $payload = json_encode($clientes);
            $response->getBody()->write($payload);
            return $response;
            
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        };
    });

    //Buscar vehiculo (todos)
    $app->get('/vehiculos', function ($request, $response, $args) {
       
        $sql = "SELECT * FROM tbl_vehiculo";

        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
                $payload = json_encode($clientes);
                $response->getBody()->write($payload);
                return $response
                    ->withHeader('Content-Type', 'application/json');
            } else {
                $payload = json_encode("No existen registros");
                $response->getBody()->write($payload);
                return $response
                    ->withHeader('Content-Type', 'application/json');
            }
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });

    //Buscar vehiculo (por patente)
    $app->get('/vehiculo/{patente}', function ($request, $response, $args) {
        $patente = $args['patente'];
        $sql = "SELECT * FROM tbl_vehiculo WHERE patente='$patente'";

        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
                $payload = json_encode($clientes);
                $response->getBody()->write($payload);
                return $response
                ->withHeader('Content-Type', 'application/json');
        } else {
                $payload = json_encode("No existen registros");
                $response->getBody()->write($payload);
                return $response
                ->withHeader('Content-Type', 'application/json');
        }
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });

    //Agregar un nuevo registro
    $app->post('/vehiculo/nuevo', function ($request, $response, $args) {
        $patente        = $request->getParam('patente');
        $marca          = $request->getParam('marca');
        $modelo         = $request->getParam('modelo');
        $color          = $request->getParam('color');
        $fecha          = $request->getParam('fecha_fabricacion');
        $kilometraje    = $request->getParam('kilometraje');
        $rut_cliente    = $request->getParam('rut_cliente');
        

        //Consulta
        $sql = "INSERT INTO tbl_vehiculo (patente,marca,modelo,color,fecha_fabricacion,kilometraje,rut_cliente) VALUES
                                         (:patente, :marca, :modelo, :color, :fecha_fabricacion, :kilometraje, :rut_cliente)";
    
        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->prepare($sql);

            $resultado->bindParam(':patente', $patente);
            $resultado->bindParam(':marca', $marca);
            $resultado->bindParam(':modelo', $modelo);
            $resultado->bindParam(':color', $color);
            $resultado->bindParam(':fecha_fabricacion', $fecha);
            $resultado->bindParam(':kilometraje', $kilometraje);
            $resultado->bindParam(':rut_cliente', $rut_cliente);

            $resultado->execute();
                
            $vehiculo = $resultado->fetchAll(PDO::FETCH_OBJ);
            $payload = json_encode($vehiculo);
            $response->getBody()->write($payload);
            return $response;
            echo $response;
                
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });

    //MODIFICAR un registro
    $app->put('/vehiculo/modificar/{patente}', function ($request, $response, $args) {
        $patente        = $args['patente'];
        $marca          = $request->getParam('marca');
        $modelo         = $request->getParam('modelo');
        $color          = $request->getParam('color');
        $fecha          = $request->getParam('fecha_fabricacion');
        $kilometraje    = $request->getParam('kilometraje');
        $rut_cliente    = $request->getParam('rut_cliente');

        //Consulta
        $sql = "UPDATE tbl_vehiculo SET
                
                marca               = :marca,
                modelo              = :modelo,
                color               = :color,
                fecha_fabricacion   = :fecha_fabricacion,
                kilometraje         = :kilometraje,
                rut_cliente         = :rut_cliente
                WHERE patente       = '$patente'";

        try{
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->prepare($sql);

          
            $resultado->bindParam(':marca', $marca);
            $resultado->bindParam(':modelo', $modelo);
            $resultado->bindParam(':color', $color);
            $resultado->bindParam(':fecha_fabricacion', $fecha);
            $resultado->bindParam(':kilometraje', $kilometraje);
            $resultado->bindParam(':rut_cliente', $rut_cliente);
            
            $resultado->execute();
            
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            $payload = json_encode($clientes);
            $response->getBody()->write($payload);
            return $response;
            
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        };
    });

    //Buscar repuestos (todos)
    $app->get('/repuestos', function ($request, $response, $args) {
       
        $sql = "SELECT * FROM tbl_repuesto";

        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
                $payload = json_encode($clientes);
                $response->getBody()->write($payload);
                return $response
                    ->withHeader('Content-Type', 'application/json');
            } else {
                $payload = json_encode("No existen registros");
                $response->getBody()->write($payload);
                return $response
                    ->withHeader('Content-Type', 'application/json');
            }
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });

    //Buscar repuesto (por id)
    $app->get('/repuesto/{id_repuesto}', function ($request, $response, $args) {
        $codigo = $args['id_repuesto'];
        $sql = "SELECT * FROM tbl_repuesto WHERE id_repuesto='$codigo'";

        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
                $payload = json_encode($clientes);
                $response->getBody()->write($payload);
                return $response
                ->withHeader('Content-Type', 'application/json');
        } else {
                $payload = json_encode("No existen registros");
                $response->getBody()->write($payload);
                return $response
                ->withHeader('Content-Type', 'application/json');
        }
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });

    //Agregar un nuevo registro
    $app->post('/repuesto/nuevo', function ($request, $response, $args) {
       //$id_repuesto        = $request->getParam('id_repuesto');
        $descripcion        = $request->getParam('descripcion');
        $cantidad           = $request->getParam('cantidad');
        $precio_venta       = $request->getParam('precio_venta');
        $fecha_compra       = $request->getParam('fecha_compra');
       
       
        //Consulta
        $sql = "INSERT INTO tbl_repuesto (descripcion,cantidad,precio_venta,fecha_compra) VALUES
                                         (:descripcion, :cantidad, :precio_venta, :fecha_compra)";
    
        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->prepare($sql);

            //$resultado->bindParam(':id_repuesto', $id_repuesto);
            $resultado->bindParam(':descripcion', $descripcion);
            $resultado->bindParam(':cantidad', $cantidad);
            $resultado->bindParam(':precio_venta', $precio_venta);
            $resultado->bindParam(':fecha_compra', $fecha_compra);

            $resultado->execute();
                
            //$vehiculo = $resultado->fetchAll(PDO::FETCH_OBJ);
            $payload = json_encode("Datos almacenados correctamente");
            $response->getBody()->write($payload);
            return $response;
            
                
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });

    //Modificar un nuevo registro
    $app->put('/repuesto/modificar/{id_repuesto}', function ($request, $response, $args) {
        $id                 = $args['id_repuesto'];
        $descripcion        = $request->getParam('descripcion');
        $cantidad           = $request->getParam('cantidad');
        $precio_venta       = $request->getParam('precio_venta');
        $fecha_compra       = $request->getParam('fecha_compra');
       
        //Consulta
        $sql = "UPDATE tbl_repuesto SET
                
                descripcion         = :descripcion,
                cantidad            = :cantidad,
                precio_venta        = :precio_venta,
                fecha_compra        = :fecha_compra
                WHERE id_repuesto   = '$id'";
       
       
        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->prepare($sql);

            $resultado->bindParam(':descripcion', $descripcion);
            $resultado->bindParam(':cantidad', $cantidad);
            $resultado->bindParam(':precio_venta', $precio_venta);
            $resultado->bindParam(':fecha_compra', $fecha_compra);

            $resultado->execute();
                
            //$vehiculo = $resultado->fetchAll(PDO::FETCH_OBJ);
            $payload = json_encode("Datos almacenados correctamente");
            $response->getBody()->write($payload);
            return $response;
            
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });

    //Buscar ordenes (todos)
    $app->get('/ordenes', function ($request, $response, $args) {
       
        $sql = "SELECT * FROM tbl_ordenes";

        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
                $payload = json_encode($clientes);
                $response->getBody()->write($payload);
                return $response
                    ->withHeader('Content-Type', 'application/json');
            } else {
                $payload = json_encode("No existen registros");
                $response->getBody()->write($payload);
                return $response
                    ->withHeader('Content-Type', 'application/json');
            }
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });

    //Buscar orden (por id)
    $app->get('/ordenes/{id_orden}', function ($request, $response, $args) {
        $id = $args['id_orden'];
        $sql = "SELECT * FROM tbl_ordenes WHERE id_orden ='$id'";

        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->query($sql);
            if ($resultado->rowCount() > 0) {
                $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
                $payload = json_encode($clientes);
                $response->getBody()->write($payload);
                return $response
                ->withHeader('Content-Type', 'application/json');
        } else {
                $payload = json_encode("No existen registros");
                $response->getBody()->write($payload);
                return $response
                ->withHeader('Content-Type', 'application/json');
        }
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });

    //Agregar un nuevo registro
    $app->post('/ordenes/nuevo', function ($request, $response, $args) {
        //$orden          = $request->getParam('id_orden');
        $fecha_entrada  = $request->getParam('fecha_entrada');
        $fecha_salida   = $request->getParam('fecha_salida');
        $total          = $request->getParam('total');
        $rut_cliente    = $request->getParam('rut_cliente');
        $patente        = $request->getParam('patente');
        $id_repuesto    = $request->getParam('id_repuesto');
       
    
        //Consulta
        $sql = "INSERT INTO tbl_ordenes (fecha_entrada,fecha_salida,total,rut_cliente,patente,id_repuesto) VALUES
                                         (:fecha_entrada, :fecha_salida, :total, :rut_cliente, :patente, :id_repuesto)";
    
        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->prepare($sql);

            //$resultado->bindParam(':id_orden', $orden);
            $resultado->bindParam(':fecha_entrada', $fecha_entrada);
            $resultado->bindParam(':fecha_salida', $fecha_salida);
            $resultado->bindParam(':total', $total);
            $resultado->bindParam(':rut_cliente', $rut_cliente);
            $resultado->bindParam(':patente', $patente);
            $resultado->bindParam(':id_repuesto', $id_repuesto);

            $resultado->execute();
                
            //$vehiculo = $resultado->fetchAll(PDO::FETCH_OBJ);
            $payload = json_encode("Datos almacenados correctamente");
            $response->getBody()->write($payload);
            return $response;
            
                
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });

    //Modificar un nuevo registro
    $app->put('/ordenes/modificar/{id_orden}', function ($request, $response, $args) {
        $id                 = $args['id_orden'];
        $fecha_entrada  = $request->getParam('fecha_entrada');
        $fecha_salida   = $request->getParam('fecha_salida');
        $total          = $request->getParam('total');
        $rut_cliente    = $request->getParam('rut_cliente');
        $patente        = $request->getParam('patente');
        $id_repuesto    = $request->getParam('id_repuesto');
       
        //Consulta
        $sql = "UPDATE tbl_ordenes SET
                
                fecha_entrada       = :fecha_entrada,
                fecha_salida        = :fecha_salida,
                total               = :total,
                rut_cliente         = :rut_cliente,
                patente             = :patente,
                id_repuesto         = :id_repuesto
                WHERE id_orden      = '$id'";
       
        try {
            $db = new db();
            $db = $db->conectbd();
            $resultado = $db->prepare($sql);

            $resultado->bindParam(':fecha_entrada', $fecha_entrada);
            $resultado->bindParam(':fecha_salida', $fecha_salida);
            $resultado->bindParam(':total', $total);
            $resultado->bindParam(':rut_cliente', $rut_cliente);
            $resultado->bindParam(':patente', $patente);
            $resultado->bindParam(':id_repuesto', $id_repuesto);

            $resultado->execute();
                
            //$vehiculo = $resultado->fetchAll(PDO::FETCH_OBJ);
            $payload = json_encode("Datos modificados correctamente");
            $response->getBody()->write($payload);
            return $response;
            
        } catch (PDOException $e) {
            echo '{"error" : {"text":' . $e->getMessage() . '}';
        }
    });
};