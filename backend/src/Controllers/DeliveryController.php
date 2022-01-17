<?php

namespace Source\Controllers;

use Source\Models\Delivery;

/**
 * @OA\Info(title="Controller Delivery", version="1.0")
 */
class DeliveryController
{
    /**
     * 
     * Essa rota foi editada para não retonar apenas os valores do campos da tabela delivery, 
     * mas também para retornar o nome do status, nome do motoboy, e nome de seus respectivos ids.
     * 
     * @OA\Get(
     *     path="/development/entrevistas/Husky/delivery",
     *     tags={"Delivery"},
     *     summary="Retorna o registro de todas as entregas.",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="string"
     *         ),
     *     ),
     * )
     */
    public function index(): void
    {
        $devilery = (new Delivery())->find()->fetch(true);

        foreach ($devilery as $value) {
            $value->data()->user_name = $value->user_name();
            $value->data()->motoboy_name = $value->motoboy_name();
            $value->data()->status_name = $value->status_name();
        }
        echo json_encode(objectToArray($devilery));
    }


    public function store(array $data): void
    {
        $motoboyId = null;
        if ($data['motoboy_id'] != 0) {
            $motoboyId = filter_var($data['motoboy_id'], FILTER_SANITIZE_NUMBER_INT);
        }

        $delivery = new Delivery();
        $delivery->user_id = filter_var($data['user_id'], FILTER_SANITIZE_NUMBER_INT);
        $delivery->motoboy_id = $motoboyId;
        $delivery->collection_address = filter_var($data['collection_address'], FILTER_SANITIZE_STRIPPED);
        $delivery->destination_address = filter_var($data['destination_address'], FILTER_SANITIZE_STRIPPED);
        $delivery->status = 1;

        $delivery->save();

        if ($delivery->fail()) {
            echo json_encode($delivery->fail()->getMessage());
            return;
        }
        echo json_encode(["success" => "salvo com sucesso"]);
    }

    public function show(array $data): void
    {
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        /** @var $delivery Delivery */
        $delivery = (new Delivery())->findById($id);
        if ($delivery) {
            $delivery->data()->user_name = $delivery->user_name();
            $delivery->data()->motoboy_name = $delivery->motoboy_name();
            $delivery->data()->status_name = $delivery->status_name();
            if ($delivery->motoboy_id == null) {
                $delivery->motoboy_id = "0";
            }

            echo json_encode(objectToArray($delivery));
        } else {
            echo json_encode("Entrega não cadastrada");
        }
    }

    /**
     * @OA\Put(
     *     path="/development/entrevistas/Husky/delivery/{id} ",
     *     tags={"Delivery"},
     *     summary="Atualiza uma entrega.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do usuario para atualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="collection_address",
     *         in="query",
     *         description="Endereço de coleta",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="destination_address",
     *         in="query",
     *         description="Endereço de destino",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="Id do usuario",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="motoboy_id",
     *         in="query",
     *         description="Id do motoboy",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Id do status",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid username supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *     )
     * )
     */
    public function update(array $data): void
    {
        echo json_encode($data);exit;
        $data = filter_var_array($data, [
            "id" => FILTER_SANITIZE_NUMBER_INT,
            "user_id" => FILTER_SANITIZE_NUMBER_INT,
            "status" => FILTER_SANITIZE_NUMBER_INT,
            "motoboy_id" => FILTER_SANITIZE_NUMBER_INT,
            "collection_address" => FILTER_SANITIZE_STRIPPED,
            "destination_address" => FILTER_SANITIZE_STRIPPED,
        ]);

        $motoboyId = null;
        if ($data['motoboy_id'] != 0) {
            $motoboyId = filter_var($data['motoboy_id'], FILTER_SANITIZE_NUMBER_INT);
        }

        $delivery = (new Delivery())->findById($data['id']);

        $delivery->user_id = $data['user_id'];
        $delivery->motoboy_id = $motoboyId;
        $delivery->collection_address = $data['collection_address'];
        $delivery->destination_address = $data['destination_address'];
        $delivery->status = $data['status'];

        $delivery->change()->save();

        if ($delivery->fail()) {
            echo json_encode($delivery->fail()->getMessage());
            return;
        }
        /**
         * Esse retono esta dessa forma pra facilitar na implementação do front end, pode ser qualquer
         * coisa necessaria para o projeto.
         */
        echo json_encode([
            "success" => "atualizado com sucesso",
            "id" => $data['id']
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/development/entrevistas/Husky/delivery/{id} ",
     *     tags={"Delivery"},
     *     summary="Deleta o registro de uma entrega.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id da entrega que precisa apagar",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid username supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *     )
     * )
     */
    public function delete(array $data): void
    {
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        $delivery = (new Delivery())->findById($id);

        if ($delivery) {
            $delivery->destroy();
            echo json_encode(["success" => "deletado com sucesso"]);
        } else {
            echo json_encode("Entrega invalida.");
        }
    }   
}
