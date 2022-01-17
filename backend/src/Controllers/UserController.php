<?php

namespace Source\Controllers;

use Source\Models\User;

class UserController
{
    /**
     * 
     * @OA\Get(
     *     path="/monorepo_husky/backend/user",
     *     tags={"User"},
     *     summary="Retorna o registro de todos os usuários.",
     *         *     @OA\Response(
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
        echo json_encode(objectToArray((new User())->find()->fetch(true)));
    }

    public function store(array $data): void
    {
        $user = new User();
        $user->name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $user->address = filter_var($data['address'], FILTER_SANITIZE_STRING);
        $user->save();

        if ($user->fail()) {
            echo json_encode($user->fail()->getMessage());
            return;
        }

        echo json_encode(["success" => "salvo com sucesso"]);
    }

    /**
     * @OA\Get(
     *     path="/monorepo_husky/backend/user/{id}",
     *     tags={"User"},
     *     summary="Essa rota devolve apenas um usuario especifico atraves do id.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do usuario   ",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="string"
     *         ),
     *     ),
     * )
     */
    public function show(array $data): void
    {
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        echo json_encode(objectToArray((new User())->findById($id)));
    }

    public function update(array $data): void
    {
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        $user = (new User())->findById($id);
        $user->name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $user->address = filter_var($data['address'], FILTER_SANITIZE_STRING);

        $user->change()->save();

        if ($user->fail()) {
            echo json_encode($user->fail()->getMessage());
            return;
        }

        echo json_encode(["success" => "atualizado com sucesso"]);
    }

    /**
     * @OA\Delete(
     *     path="/monorepo_husky/backend/user/{id} ",
     *     tags={"User"},
     *     summary="Deleta um registro de usuario.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do usuario que precisa apagar",
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

        $user = (new User())->findById($id);

        if ($user) {
            $user->destroy();
            echo json_encode(["success" => "deletado com sucesso"]);
        } else {
            echo json_encode("usuario inválido.");
        }
    }
}
