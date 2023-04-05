<?php 

namespace App\Ordenservicio\Domain\Entities;

use Sophy\Domain\BaseEntity;

final class Ordenservicio extends BaseEntity
{

    protected $fillable = [
        'ordenservicio_id',
        'booking_id',
        'chofer_id',
        'ordenservicio_identificador',
        'ordenservicio_terminalretiro',
        'ordenservicio_programacion',
        'ordenservicio_planta',
        'ordenservicio_contenedor',
        'ordenservicio_tara',
        'ordenservicio_payload',
        'ordenservicio_precintoaduanaid',
        'ordenservicio_estado',
        'ordenservicio_carreta',
        'ordenservicio_precintoaduana',
        'ordenservicio_precintolinea',
        'ordenservicio_precintovacio',
        'ordenservicio_termoregistro',
        'proveedor_id',
        'vehiculo_id',
        'usuario_id',
        'ordenservicio_ficheroeir',
        'ordenservicio_ficheroeirfecha',
        'ordenservicio_os',
        'ordenservicio_dam',
        'ordenservicio_numerorce',
        'ordenservicio_fechanumeracion',
        'packing_id',
        'ordenservicio_destino',
        'ordenservicio_tipoaforo',
        'ordenservicio_canal',
        'ordenservicio_precintofinalid',
        'ordenservicio_precintofinal',
        'ordenservicio_precintofinallinea',
        'ordenservicio_fecha',
        'embarcador_id',
        'ordenservicio_termoregistro2',
        'ordenservicio_despachado',
        'ordenservicio_fechadespacho',
        'ordenservicio_usuariodespachoid',
        'ordenservicio_tipoembarque',
        'ordenservicio_precintolatitud',
        'ordenservicio_precintolongitud',
        'ordenservicio_precintoqr',
        'ordenservicio_precintoaduanarequired',
        'ordenservicio_bookinganterior',
        'ordenservicio_ficherobolsa',
        'ordenservicio_ficherobolsafecha',
        'ordenservicio_fechacarga',
        'ordenservicio_ficheroacta',
        'ordenservicio_ficheroactafecha',
        'ordenservicio_fechaingresocontenedor',
        'ordenservicio_terminalembarque',
        'ordenservicio_precintoadicional1',
        'ordenservicio_precintoadicional2',
        'ordenservicio_precintoadicional1nombre',
        'ordenservicio_precintoadicional2nombre',
        'ordenservicio_nroguiatransporte',
        'ordenservicio_tarifa',
        'ordenservicio_ficheroactaprecinto',
        'ordenservicio_ficheroactaprecintofecha',
        'ordenservicio_obsprecintoaduana',
        'ordenservicio_obsprecintofinal',
        'ordenservicio_obsprecintoadicional1',
        'ordenservicio_tipo',
        'ordenservicio_sti',
        'ordenservicio_factura',
    ];

    public function setOrdenservicio_id($ordenservicio_id){ 
        $this->setAttribute('ordenservicio_id', $ordenservicio_id);
    }

    public function getOrdenservicio_id(){ 
        return $this->getAttribute('ordenservicio_id');
    }

    public function setBooking_id($booking_id){ 
        $this->setAttribute('booking_id', $booking_id);
    }

    public function getBooking_id(){ 
        return $this->getAttribute('booking_id');
    }

    public function setChofer_id($chofer_id){ 
        $this->setAttribute('chofer_id', $chofer_id);
    }

    public function getChofer_id(){ 
        return $this->getAttribute('chofer_id');
    }

    public function setOrdenservicio_identificador($ordenservicio_identificador){ 
        $this->setAttribute('ordenservicio_identificador', $ordenservicio_identificador);
    }

    public function getOrdenservicio_identificador(){ 
        return $this->getAttribute('ordenservicio_identificador');
    }

    public function setOrdenservicio_terminalretiro($ordenservicio_terminalretiro){ 
        $this->setAttribute('ordenservicio_terminalretiro', $ordenservicio_terminalretiro);
    }

    public function getOrdenservicio_terminalretiro(){ 
        return $this->getAttribute('ordenservicio_terminalretiro');
    }

    public function setOrdenservicio_programacion($ordenservicio_programacion){ 
        $this->setAttribute('ordenservicio_programacion', $ordenservicio_programacion);
    }

    public function getOrdenservicio_programacion(){ 
        return $this->getAttribute('ordenservicio_programacion');
    }

    public function setOrdenservicio_planta($ordenservicio_planta){ 
        $this->setAttribute('ordenservicio_planta', $ordenservicio_planta);
    }

    public function getOrdenservicio_planta(){ 
        return $this->getAttribute('ordenservicio_planta');
    }

    public function setOrdenservicio_contenedor($ordenservicio_contenedor){ 
        $this->setAttribute('ordenservicio_contenedor', $ordenservicio_contenedor);
    }

    public function getOrdenservicio_contenedor(){ 
        return $this->getAttribute('ordenservicio_contenedor');
    }

    public function setOrdenservicio_tara($ordenservicio_tara){ 
        $this->setAttribute('ordenservicio_tara', $ordenservicio_tara);
    }

    public function getOrdenservicio_tara(){ 
        return $this->getAttribute('ordenservicio_tara');
    }

    public function setOrdenservicio_payload($ordenservicio_payload){ 
        $this->setAttribute('ordenservicio_payload', $ordenservicio_payload);
    }

    public function getOrdenservicio_payload(){ 
        return $this->getAttribute('ordenservicio_payload');
    }

    public function setOrdenservicio_precintoaduanaid($ordenservicio_precintoaduanaid){ 
        $this->setAttribute('ordenservicio_precintoaduanaid', $ordenservicio_precintoaduanaid);
    }

    public function getOrdenservicio_precintoaduanaid(){ 
        return $this->getAttribute('ordenservicio_precintoaduanaid');
    }

    public function setOrdenservicio_estado($ordenservicio_estado){ 
        $this->setAttribute('ordenservicio_estado', $ordenservicio_estado);
    }

    public function getOrdenservicio_estado(){ 
        return $this->getAttribute('ordenservicio_estado');
    }

    public function setOrdenservicio_carreta($ordenservicio_carreta){ 
        $this->setAttribute('ordenservicio_carreta', $ordenservicio_carreta);
    }

    public function getOrdenservicio_carreta(){ 
        return $this->getAttribute('ordenservicio_carreta');
    }

    public function setOrdenservicio_precintoaduana($ordenservicio_precintoaduana){ 
        $this->setAttribute('ordenservicio_precintoaduana', $ordenservicio_precintoaduana);
    }

    public function getOrdenservicio_precintoaduana(){ 
        return $this->getAttribute('ordenservicio_precintoaduana');
    }

    public function setOrdenservicio_precintolinea($ordenservicio_precintolinea){ 
        $this->setAttribute('ordenservicio_precintolinea', $ordenservicio_precintolinea);
    }

    public function getOrdenservicio_precintolinea(){ 
        return $this->getAttribute('ordenservicio_precintolinea');
    }

    public function setOrdenservicio_precintovacio($ordenservicio_precintovacio){ 
        $this->setAttribute('ordenservicio_precintovacio', $ordenservicio_precintovacio);
    }

    public function getOrdenservicio_precintovacio(){ 
        return $this->getAttribute('ordenservicio_precintovacio');
    }

    public function setOrdenservicio_termoregistro($ordenservicio_termoregistro){ 
        $this->setAttribute('ordenservicio_termoregistro', $ordenservicio_termoregistro);
    }

    public function getOrdenservicio_termoregistro(){ 
        return $this->getAttribute('ordenservicio_termoregistro');
    }

    public function setProveedor_id($proveedor_id){ 
        $this->setAttribute('proveedor_id', $proveedor_id);
    }

    public function getProveedor_id(){ 
        return $this->getAttribute('proveedor_id');
    }

    public function setVehiculo_id($vehiculo_id){ 
        $this->setAttribute('vehiculo_id', $vehiculo_id);
    }

    public function getVehiculo_id(){ 
        return $this->getAttribute('vehiculo_id');
    }

    public function setUsuario_id($usuario_id){ 
        $this->setAttribute('usuario_id', $usuario_id);
    }

    public function getUsuario_id(){ 
        return $this->getAttribute('usuario_id');
    }

    public function setOrdenservicio_ficheroeir($ordenservicio_ficheroeir){ 
        $this->setAttribute('ordenservicio_ficheroeir', $ordenservicio_ficheroeir);
    }

    public function getOrdenservicio_ficheroeir(){ 
        return $this->getAttribute('ordenservicio_ficheroeir');
    }

    public function setOrdenservicio_ficheroeirfecha($ordenservicio_ficheroeirfecha){ 
        $this->setAttribute('ordenservicio_ficheroeirfecha', $ordenservicio_ficheroeirfecha);
    }

    public function getOrdenservicio_ficheroeirfecha(){ 
        return $this->getAttribute('ordenservicio_ficheroeirfecha');
    }

    public function setOrdenservicio_os($ordenservicio_os){ 
        $this->setAttribute('ordenservicio_os', $ordenservicio_os);
    }

    public function getOrdenservicio_os(){ 
        return $this->getAttribute('ordenservicio_os');
    }

    public function setOrdenservicio_dam($ordenservicio_dam){ 
        $this->setAttribute('ordenservicio_dam', $ordenservicio_dam);
    }

    public function getOrdenservicio_dam(){ 
        return $this->getAttribute('ordenservicio_dam');
    }

    public function setOrdenservicio_numerorce($ordenservicio_numerorce){ 
        $this->setAttribute('ordenservicio_numerorce', $ordenservicio_numerorce);
    }

    public function getOrdenservicio_numerorce(){ 
        return $this->getAttribute('ordenservicio_numerorce');
    }

    public function setOrdenservicio_fechanumeracion($ordenservicio_fechanumeracion){ 
        $this->setAttribute('ordenservicio_fechanumeracion', $ordenservicio_fechanumeracion);
    }

    public function getOrdenservicio_fechanumeracion(){ 
        return $this->getAttribute('ordenservicio_fechanumeracion');
    }

    public function setPacking_id($packing_id){ 
        $this->setAttribute('packing_id', $packing_id);
    }

    public function getPacking_id(){ 
        return $this->getAttribute('packing_id');
    }

    public function setOrdenservicio_destino($ordenservicio_destino){ 
        $this->setAttribute('ordenservicio_destino', $ordenservicio_destino);
    }

    public function getOrdenservicio_destino(){ 
        return $this->getAttribute('ordenservicio_destino');
    }

    public function setOrdenservicio_tipoaforo($ordenservicio_tipoaforo){ 
        $this->setAttribute('ordenservicio_tipoaforo', $ordenservicio_tipoaforo);
    }

    public function getOrdenservicio_tipoaforo(){ 
        return $this->getAttribute('ordenservicio_tipoaforo');
    }

    public function setOrdenservicio_canal($ordenservicio_canal){ 
        $this->setAttribute('ordenservicio_canal', $ordenservicio_canal);
    }

    public function getOrdenservicio_canal(){ 
        return $this->getAttribute('ordenservicio_canal');
    }

    public function setOrdenservicio_precintofinalid($ordenservicio_precintofinalid){ 
        $this->setAttribute('ordenservicio_precintofinalid', $ordenservicio_precintofinalid);
    }

    public function getOrdenservicio_precintofinalid(){ 
        return $this->getAttribute('ordenservicio_precintofinalid');
    }

    public function setOrdenservicio_precintofinal($ordenservicio_precintofinal){ 
        $this->setAttribute('ordenservicio_precintofinal', $ordenservicio_precintofinal);
    }

    public function getOrdenservicio_precintofinal(){ 
        return $this->getAttribute('ordenservicio_precintofinal');
    }

    public function setOrdenservicio_precintofinallinea($ordenservicio_precintofinallinea){ 
        $this->setAttribute('ordenservicio_precintofinallinea', $ordenservicio_precintofinallinea);
    }

    public function getOrdenservicio_precintofinallinea(){ 
        return $this->getAttribute('ordenservicio_precintofinallinea');
    }

    public function setOrdenservicio_fecha($ordenservicio_fecha){ 
        $this->setAttribute('ordenservicio_fecha', $ordenservicio_fecha);
    }

    public function getOrdenservicio_fecha(){ 
        return $this->getAttribute('ordenservicio_fecha');
    }

    public function setEmbarcador_id($embarcador_id){ 
        $this->setAttribute('embarcador_id', $embarcador_id);
    }

    public function getEmbarcador_id(){ 
        return $this->getAttribute('embarcador_id');
    }

    public function setOrdenservicio_termoregistro2($ordenservicio_termoregistro2){ 
        $this->setAttribute('ordenservicio_termoregistro2', $ordenservicio_termoregistro2);
    }

    public function getOrdenservicio_termoregistro2(){ 
        return $this->getAttribute('ordenservicio_termoregistro2');
    }

    public function setOrdenservicio_despachado($ordenservicio_despachado){ 
        $this->setAttribute('ordenservicio_despachado', $ordenservicio_despachado);
    }

    public function getOrdenservicio_despachado(){ 
        return $this->getAttribute('ordenservicio_despachado');
    }

    public function setOrdenservicio_fechadespacho($ordenservicio_fechadespacho){ 
        $this->setAttribute('ordenservicio_fechadespacho', $ordenservicio_fechadespacho);
    }

    public function getOrdenservicio_fechadespacho(){ 
        return $this->getAttribute('ordenservicio_fechadespacho');
    }

    public function setOrdenservicio_usuariodespachoid($ordenservicio_usuariodespachoid){ 
        $this->setAttribute('ordenservicio_usuariodespachoid', $ordenservicio_usuariodespachoid);
    }

    public function getOrdenservicio_usuariodespachoid(){ 
        return $this->getAttribute('ordenservicio_usuariodespachoid');
    }

    public function setOrdenservicio_tipoembarque($ordenservicio_tipoembarque){ 
        $this->setAttribute('ordenservicio_tipoembarque', $ordenservicio_tipoembarque);
    }

    public function getOrdenservicio_tipoembarque(){ 
        return $this->getAttribute('ordenservicio_tipoembarque');
    }

    public function setOrdenservicio_precintolatitud($ordenservicio_precintolatitud){ 
        $this->setAttribute('ordenservicio_precintolatitud', $ordenservicio_precintolatitud);
    }

    public function getOrdenservicio_precintolatitud(){ 
        return $this->getAttribute('ordenservicio_precintolatitud');
    }

    public function setOrdenservicio_precintolongitud($ordenservicio_precintolongitud){ 
        $this->setAttribute('ordenservicio_precintolongitud', $ordenservicio_precintolongitud);
    }

    public function getOrdenservicio_precintolongitud(){ 
        return $this->getAttribute('ordenservicio_precintolongitud');
    }

    public function setOrdenservicio_precintoqr($ordenservicio_precintoqr){ 
        $this->setAttribute('ordenservicio_precintoqr', $ordenservicio_precintoqr);
    }

    public function getOrdenservicio_precintoqr(){ 
        return $this->getAttribute('ordenservicio_precintoqr');
    }

    public function setOrdenservicio_precintoaduanarequired($ordenservicio_precintoaduanarequired){ 
        $this->setAttribute('ordenservicio_precintoaduanarequired', $ordenservicio_precintoaduanarequired);
    }

    public function getOrdenservicio_precintoaduanarequired(){ 
        return $this->getAttribute('ordenservicio_precintoaduanarequired');
    }

    public function setOrdenservicio_bookinganterior($ordenservicio_bookinganterior){ 
        $this->setAttribute('ordenservicio_bookinganterior', $ordenservicio_bookinganterior);
    }

    public function getOrdenservicio_bookinganterior(){ 
        return $this->getAttribute('ordenservicio_bookinganterior');
    }

    public function setOrdenservicio_ficherobolsa($ordenservicio_ficherobolsa){ 
        $this->setAttribute('ordenservicio_ficherobolsa', $ordenservicio_ficherobolsa);
    }

    public function getOrdenservicio_ficherobolsa(){ 
        return $this->getAttribute('ordenservicio_ficherobolsa');
    }

    public function setOrdenservicio_ficherobolsafecha($ordenservicio_ficherobolsafecha){ 
        $this->setAttribute('ordenservicio_ficherobolsafecha', $ordenservicio_ficherobolsafecha);
    }

    public function getOrdenservicio_ficherobolsafecha(){ 
        return $this->getAttribute('ordenservicio_ficherobolsafecha');
    }

    public function setOrdenservicio_fechacarga($ordenservicio_fechacarga){ 
        $this->setAttribute('ordenservicio_fechacarga', $ordenservicio_fechacarga);
    }

    public function getOrdenservicio_fechacarga(){ 
        return $this->getAttribute('ordenservicio_fechacarga');
    }

    public function setOrdenservicio_ficheroacta($ordenservicio_ficheroacta){ 
        $this->setAttribute('ordenservicio_ficheroacta', $ordenservicio_ficheroacta);
    }

    public function getOrdenservicio_ficheroacta(){ 
        return $this->getAttribute('ordenservicio_ficheroacta');
    }

    public function setOrdenservicio_ficheroactafecha($ordenservicio_ficheroactafecha){ 
        $this->setAttribute('ordenservicio_ficheroactafecha', $ordenservicio_ficheroactafecha);
    }

    public function getOrdenservicio_ficheroactafecha(){ 
        return $this->getAttribute('ordenservicio_ficheroactafecha');
    }

    public function setOrdenservicio_fechaingresocontenedor($ordenservicio_fechaingresocontenedor){ 
        $this->setAttribute('ordenservicio_fechaingresocontenedor', $ordenservicio_fechaingresocontenedor);
    }

    public function getOrdenservicio_fechaingresocontenedor(){ 
        return $this->getAttribute('ordenservicio_fechaingresocontenedor');
    }

    public function setOrdenservicio_terminalembarque($ordenservicio_terminalembarque){ 
        $this->setAttribute('ordenservicio_terminalembarque', $ordenservicio_terminalembarque);
    }

    public function getOrdenservicio_terminalembarque(){ 
        return $this->getAttribute('ordenservicio_terminalembarque');
    }

    public function setOrdenservicio_precintoadicional1($ordenservicio_precintoadicional1){ 
        $this->setAttribute('ordenservicio_precintoadicional1', $ordenservicio_precintoadicional1);
    }

    public function getOrdenservicio_precintoadicional1(){ 
        return $this->getAttribute('ordenservicio_precintoadicional1');
    }

    public function setOrdenservicio_precintoadicional2($ordenservicio_precintoadicional2){ 
        $this->setAttribute('ordenservicio_precintoadicional2', $ordenservicio_precintoadicional2);
    }

    public function getOrdenservicio_precintoadicional2(){ 
        return $this->getAttribute('ordenservicio_precintoadicional2');
    }

    public function setOrdenservicio_precintoadicional1nombre($ordenservicio_precintoadicional1nombre){ 
        $this->setAttribute('ordenservicio_precintoadicional1nombre', $ordenservicio_precintoadicional1nombre);
    }

    public function getOrdenservicio_precintoadicional1nombre(){ 
        return $this->getAttribute('ordenservicio_precintoadicional1nombre');
    }

    public function setOrdenservicio_precintoadicional2nombre($ordenservicio_precintoadicional2nombre){ 
        $this->setAttribute('ordenservicio_precintoadicional2nombre', $ordenservicio_precintoadicional2nombre);
    }

    public function getOrdenservicio_precintoadicional2nombre(){ 
        return $this->getAttribute('ordenservicio_precintoadicional2nombre');
    }

    public function setOrdenservicio_nroguiatransporte($ordenservicio_nroguiatransporte){ 
        $this->setAttribute('ordenservicio_nroguiatransporte', $ordenservicio_nroguiatransporte);
    }

    public function getOrdenservicio_nroguiatransporte(){ 
        return $this->getAttribute('ordenservicio_nroguiatransporte');
    }

    public function setOrdenservicio_tarifa($ordenservicio_tarifa){ 
        $this->setAttribute('ordenservicio_tarifa', $ordenservicio_tarifa);
    }

    public function getOrdenservicio_tarifa(){ 
        return $this->getAttribute('ordenservicio_tarifa');
    }

    public function setOrdenservicio_ficheroactaprecinto($ordenservicio_ficheroactaprecinto){ 
        $this->setAttribute('ordenservicio_ficheroactaprecinto', $ordenservicio_ficheroactaprecinto);
    }

    public function getOrdenservicio_ficheroactaprecinto(){ 
        return $this->getAttribute('ordenservicio_ficheroactaprecinto');
    }

    public function setOrdenservicio_ficheroactaprecintofecha($ordenservicio_ficheroactaprecintofecha){ 
        $this->setAttribute('ordenservicio_ficheroactaprecintofecha', $ordenservicio_ficheroactaprecintofecha);
    }

    public function getOrdenservicio_ficheroactaprecintofecha(){ 
        return $this->getAttribute('ordenservicio_ficheroactaprecintofecha');
    }

    public function setOrdenservicio_obsprecintoaduana($ordenservicio_obsprecintoaduana){ 
        $this->setAttribute('ordenservicio_obsprecintoaduana', $ordenservicio_obsprecintoaduana);
    }

    public function getOrdenservicio_obsprecintoaduana(){ 
        return $this->getAttribute('ordenservicio_obsprecintoaduana');
    }

    public function setOrdenservicio_obsprecintofinal($ordenservicio_obsprecintofinal){ 
        $this->setAttribute('ordenservicio_obsprecintofinal', $ordenservicio_obsprecintofinal);
    }

    public function getOrdenservicio_obsprecintofinal(){ 
        return $this->getAttribute('ordenservicio_obsprecintofinal');
    }

    public function setOrdenservicio_obsprecintoadicional1($ordenservicio_obsprecintoadicional1){ 
        $this->setAttribute('ordenservicio_obsprecintoadicional1', $ordenservicio_obsprecintoadicional1);
    }

    public function getOrdenservicio_obsprecintoadicional1(){ 
        return $this->getAttribute('ordenservicio_obsprecintoadicional1');
    }

    public function setOrdenservicio_tipo($ordenservicio_tipo){ 
        $this->setAttribute('ordenservicio_tipo', $ordenservicio_tipo);
    }

    public function getOrdenservicio_tipo(){ 
        return $this->getAttribute('ordenservicio_tipo');
    }

    public function setOrdenservicio_sti($ordenservicio_sti){ 
        $this->setAttribute('ordenservicio_sti', $ordenservicio_sti);
    }

    public function getOrdenservicio_sti(){ 
        return $this->getAttribute('ordenservicio_sti');
    }

    public function setOrdenservicio_factura($ordenservicio_factura){ 
        $this->setAttribute('ordenservicio_factura', $ordenservicio_factura);
    }

    public function getOrdenservicio_factura(){ 
        return $this->getAttribute('ordenservicio_factura');
    }

}
?>