<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 10/02/18
 * Time: 17:07
 */

namespace App\BLL;


use App\Entity\Provincias;
use App\Entity\Roles;
use App\Entity\Usuarios;
use App\BLL\BaseBLL;
use Doctrine\Common\Persistence\ObjectManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsuarioBLL extends BaseBLL
{
    /**
     * @var JWTTokenManagerInterface
     */
    private $jwtManager;

    public function setJWTManager(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    /**
     * @var UserPasswordEncoderInterface $encoder
     */
    private $encoder;

    public function setEncoder(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function getTokenByEmail($email)
    {
        $user = $this->em->getRepository(Usuarios::class)->findOneBy(array('email'=>$email));
        if (is_null($user))
            throw new AccessDeniedHttpException('Usuario no autorizado');

        return $this->jwtManager->create($user);
    }

    public function getAllRest(){
        return $this->entitiesToArray($this->em->getRepository(Usuarios::class)->findAll());
    }

    public function getAllUsuarios(array $busqueda = null)
    {
        return $this->em->getRepository(Usuarios::class)->findAll();
    }

    public function getUsuarios(array $busqueda = null)
    {
        return $this->em->getRepository(Usuarios::class)->findBy($busqueda);
    }

    public function eliminaUsuario($id)
    {
        $producto = $this->em->getRepository(Usuarios::class)->find($id);

        $this->em->remove($producto);
        $this->em->flush();
    }

    public function guardaUsuario(Usuarios $usuarios)
    {
        $password = $this->encoder->encodePassword($usuarios, $usuarios->getPassword());
        $usuarios->setPasswd($password);

        $this->em->persist($usuarios);
        $this->em->flush();
    }

    public function nuevo($data)
    {
        $user = new Usuarios();

        $user->setNombre($data['nombre']);
        $user->setPasswd($this->encoder->encodePassword($user, $data['passwd']));
        $user->setEmail($data['email']);
        $user->setProvincia($this->em->getRepository(Provincias::class)->find($data['provincia']));
        $user->setRole($this->em->getRepository(Roles::class)->find('ROLE_COMPRADOR'));
        $user->setAvatar($data['avatar']);

        return $this->guardaValidando($user);
    }

    public function actualizar(Usuarios $user, array $data)
    {
        $user->setNombre($data['nombre']);
        $user->setPasswd($this->encoder->encodePassword($user, $data['passwd']));
        $user->setEmail($data['email']);
        $user->setProvincia($this->em->getRepository(Provincias::class)->find($data['provincia']));
        $user->setRole($user->getRole());
        $user->setAvatar($data['avatar']);

        return $this->guardaValidando($user);
    }

    public function toArray($entity)
    {
        if ( is_null ($entity))
            return null;

        if (!($entity instanceof Usuarios))
            throw new \Exception("La entidad no es un Usuario");

        return [
            'id' => $entity->getId(),
            'nombre' => $entity->getNombre(),
            'provincia' => $entity->getProvincia(),
            'role' => $entity->getRole(),
            'email' => $entity->getEmail()
        ];
    }

    public function cambiaPassword($nuevoPassword)
    {
        $user = $this->getUser();

        $user->setPasswd($this->encoder->encodePassword($user, $nuevoPassword));

        return $this->guardaValidando($user);
    }


    public function profile()
    {
        $user = $this->getUser();
        return $this->toArray($user);
    }

    public function cambiaAvatar(Request $request, $avatar, $avatars_directory, $url_avatars_directory)
    {
        $user = $this->getUser();
        $arr_avatar = explode(',', $avatar);
        if (count($arr_avatar) < 2)
            throw new BadRequestHttpException('formato de imagen incorrecto');
        $imgAvatar = base64_decode($arr_avatar[1]);
        if (!is_null($imgAvatar))
        {
            $fileName = $user->getUsername().'-'.time().'.jpg';
            $filePath = $url_avatars_directory . $fileName;
            $urlAvatar = $request->getUriForPath($filePath);
            $user->setAvatar($urlAvatar);
            $ifp = fopen($avatars_directory . $fileName, "wb");
            if ($ifp)
            {
                $ok = fwrite($ifp, $avatar);
                if ($ok)
                    return $this->guardaValidando($user);
                fclose($ifp);
            }
        }
        throw new \Exception('No se ha podido cargar la imagen del avatar');
    }
}