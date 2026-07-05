<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\OrdenTrabajo;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class NuevaOrden extends Component
{
    use WithFileUploads;

    public $cliente = ['nombre' => '', 'rut' => '', 'telefono' => ''];
    public $equipo = ['marca_modelo' => '', 'imei' => '', 'falla' => '', 'clave' => '', 'tipo' => 'Smartphone'];
    
    public $checklist = [];
    public $observaciones_esteticas = '';

    public $fotos_antes = [];
    
    public $abono = 0;
    public $metodo_pago = 'Efectivo';
    
    public $firma_base64;

    public function mount()
    {
        $this->inicializarChecklist();
    }

    public function updatedEquipoTipo()
    {
        $this->inicializarChecklist();
    }

    public function inicializarChecklist()
    {
        $items = $this->equipo['tipo'] === 'Smartphone' 
            ? ['Enciende', 'Pantalla/Touch', 'Cámaras', 'Audio', 'Señal/Wi-Fi', 'Botones', 'Carga', 'Sensores', 'Mojado']
            : ['Enciende', 'Pantalla/Video', 'Teclado', 'Disco/SO', 'Wi-Fi/Red', 'Puertos', 'Batería', 'Ventilador', 'Mojado'];
            
        $this->checklist = [];
        foreach ($items as $item) {
            $this->checklist[$item] = 'na';
        }
    }

    public function setChecklist($item, $estado)
    {
        $this->checklist[$item] = $estado;
    }

    public function guardar()
    {
        $this->validate([
            'cliente.nombre' => 'required|string',
            'cliente.telefono' => 'required|string',
            'equipo.marca_modelo' => 'required|string',
            'equipo.falla' => 'required|string',
            'firma_base64' => 'required|string',
        ]);

        $clienteModel = Cliente::firstOrCreate(
            ['telefono' => $this->cliente['telefono']],
            ['nombre_completo' => $this->cliente['nombre'], 'rut_dni' => $this->cliente['rut']]
        );

        $rutasFotos = [];
        if ($this->fotos_antes) {
            foreach ($this->fotos_antes as $foto) {
                $rutasFotos[] = $foto->store('evidencia_antes', 'public');
            }
        }

        $token = Str::uuid()->toString();
        $codigoOT = 'OT-' . strtoupper(Str::random(6));

        $ot = OrdenTrabajo::create([
            'codigo_ot' => $codigoOT,
            'tracking_token' => $token,
            'cliente_id' => $clienteModel->id,
            'marca_modelo' => $this->equipo['marca_modelo'],
            'imei_serie' => $this->equipo['imei'],
            'falla_reportada' => $this->equipo['falla'],
            'contrasena_desbloqueo' => $this->equipo['clave'],
            'tipo_dispositivo' => $this->equipo['tipo'],
            'estado' => 'Ingresado',
            'checklist' => $this->checklist,
            'observaciones_esteticas' => $this->observaciones_esteticas,
            'firma_cliente' => $this->firma_base64,
            'evidencia_antes' => $rutasFotos,
            'abono' => $this->abono,
            'metodo_pago' => $this->metodo_pago,
        ]);

        session()->flash('success', 'Orden ' . $codigoOT . ' creada con éxito.');
        return redirect()->to('/nueva-orden');
    }

    public function render()
    {
        return view('livewire.nueva-orden');
    }
}
