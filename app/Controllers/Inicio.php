<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\VentasModel;
use App\Models\DetalleVentaModel;

class Inicio extends BaseController
{
	protected $productoModel,$ventasModel, $session;

	public function __construct()
    {
		$this->productoModel= New ProductosModel();
		$this->ventasModel= New VentasModel();
		$this->DVModel= New DetalleVentaModel();
		$this->session = session();
	} 

	public function index()
	{
		if (!isset($this->session->id_usuario)) {return redirect()->to(base_url());}
		$hoy= date('Y-m-d');
		$anio_actual= date('Y');
		$mes_actual= date('m');
	
		$total = $this->productoModel->totalProductos();
		$totalVentas = $this->ventasModel->totalDia($hoy);
		$totalxmeses= $this->ventasModel->totalxmes($anio_actual);
		$minimos = $this->productoModel->productosMinimo();
		$topProductMasV= $this->ventasModel->productos_mas_vendidos($mes_actual,$anio_actual);
		$datos = [
			'total'=> $total,
			'totalVentas' => $totalVentas,
			'minimos'=> $minimos,
			'totalxmeses'=> $totalxmeses,
			'topProductMasV'=> $topProductMasV
		];
		echo view('header');
		echo view('inicio', $datos);
		echo view('footer');
	}
	
}
