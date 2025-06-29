<?php

namespace App\Http\Controllers;

use App\Models\DeviceMaintenance;
use Illuminate\Http\Request;
use Mockery\Undefined;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use App\Models\Tabla1;
use App\Models\Tabla2;
use App\Models\Maintenance;

class ExcelController extends Controller
{
    public function crearFormatoExcel($id, $tipo = 'recepcion')
    {
        // 1. Crea un nuevo documento de hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();

        // $hoja->getStyle('A1:I52')->getFill()
        //     ->setFillType(Fill::FILL_SOLID)
        //     ->getStartColor()->setARGB('FFFFFFFF'); // Color de fondo

        // Agregar una imagen
        $rutaImagen = 'images/logoDigibyte.png'; // Ruta correcta sin 'public'
        $drawing = new Drawing();
        $drawing->setPath($rutaImagen); // Ruta de la imagen
        $drawing->setHeight(174); // Altura en puntos

        $drawing->setCoordinates('c2'); // Celda donde deseas insertar la imagen

        $drawing->setWorksheet($hoja); // Establece la hoja de cálculo para la imagen

        // Titulo General
        $this->setCellStyle(
            $hoja,
            'B9:H9',
            $tipo === 'recepcion' ?
            'FORMATO DE RECEPCIÓN DE EQUIPO PARA MANTENIMIENTO PREVENTIVO/CORRECTIVO' :
            'FORMATO DE ENTREGA DE EQUIPO POR MANTENIMIENTO PREVENTIVO/CORRECTIVO',
            18,
            true
        );

        // Titulo "Fecha"
        $this->setCellStyle(
            $hoja,
            'F11:H11',
            'FECHA',
            12,
            true,
            'FFFFFFFF', // blanco
            'FF305496', // azul
        );

        // HUACHO
        $this->setCellStyle(
            $hoja,
            'E13',
            'HUACHO',
            11,
            true
        );

        $equipoMantenimiento = DeviceMaintenance::with(['maintenance', 'trabajoARealizar', 'trabajoRealizado', 'maintenance.clienteRecoge', 'device', 'device.deviceType', 'device.brand', 'device.model'])->findOrFail($id);

        // Encabezados dia, mes, año
        $this->setCellStyle($hoja, 'F12', 'DÍA', 16);
        $this->setCellStyle($hoja, 'G12', 'MES', 16);
        $this->setCellStyle($hoja, 'H12', 'AÑO', 16);

        // Dividir la fecha en día, mes y año
        $fechaCreacion = \Carbon\Carbon::parse($equipoMantenimiento->created_at);
        $this->setCellStyle($hoja, 'F13', $fechaCreacion->day, 16); // Día
        $this->setCellStyle($hoja, 'G13', $fechaCreacion->format('F'), 16); // Mes en nombre
        $this->setCellStyle($hoja, 'H13', $fechaCreacion->year, 16); // Año

        // Titulo "Datos del cliente"
        $this->setCellStyle(
            $hoja,
            'B14:H14',
            'DATOS DEL CLIENTE',
            12,
            true,
            'FFFFFFFF', // blanco
            'FF305496', // azul
        );

        // Dni, Nombre, Direccion, telefono
        $this->setCellStyle($hoja, 'B15', 'DNI:', 16, true);
        $this->setCellStyle($hoja, 'B16', 'NOMBRE:', 16, true);
        $this->setCellStyle($hoja, 'B17', 'DIRECCIÓN:', 16, true);
        $this->setCellStyle($hoja, 'B18', 'TELEFONO:', 16, true);

        $this->setCellStyle($hoja, 'C15:H15', $equipoMantenimiento->maintenance->cliente->identificacion_entidad, 16);
        $this->setCellStyle($hoja, 'C16:H16', $equipoMantenimiento->maintenance->cliente->nombre_entidad, 16);
        $this->setCellStyle($hoja, 'C17:H17', $equipoMantenimiento->maintenance->cliente->direccion_entidad, 16);
        $this->setCellStyle($hoja, 'C18:H18', $equipoMantenimiento->maintenance->cliente->telefono_entidad, 16);

        // Titulo "DESCRIPCIÓN DEL(OS) EQUIPO(S)"
        $this->setCellStyle(
            $hoja,
            'B20:H20',
            'DESCRIPCIÓN DEL(OS) EQUIPO(S)',
            12,
            true,
            'FFFFFFFF', // blanco
            'FF305496', // azul
        );

        // Dispositivo, Marca, Modelo, Serie, Condiciones Fisicas
        $this->setCellStyle(
            $hoja,
            'B21',
            'DISPOSITIVO',
            14,
            true,
            'FF000000', // negro
            'FFB4C6E7', // azul claro
        );

        $this->setCellStyle(
            $hoja,
            'C21',
            'MARCA',
            14,
            true,
            'FF000000', // negro
            'FFB4C6E7', // azul claro
        );

        $this->setCellStyle(
            $hoja,
            'D21',
            'MODELO',
            14,
            true,
            'FF000000', // negro
            'FFB4C6E7', // azul claro
        );

        $this->setCellStyle(
            $hoja,
            'E21',
            'SERIE',
            14,
            true,
            'FF000000', // negro
            'FFB4C6E7', // azul claro
        );

        $this->setCellStyle(
            $hoja,
            'F21:H21',
            'CONDICIONES FÍSICAS O TÉCNICAS',
            14,
            true,
            'FF000000', // negro
            'FFB4C6E7', // azul claro
        );

        // tipo dispositivo
        $this->setCellStyle($hoja, 'B22:B28', $equipoMantenimiento->device->deviceType->tipo_dispositivo, 14);

        // marca
        $this->setCellStyle($hoja, 'C22:C28', $equipoMantenimiento->device->brand->nombre_marca, 14);

        // modelo
        $this->setCellStyle($hoja, 'D22:D28', $equipoMantenimiento->device->model->nombre_modelo, 14);

        $this->setCellStyle($hoja, 'E22:E28', $equipoMantenimiento->serie ?? 'Sin numero de serie especificado', 14);

        // condiciones fisicas
        $this->setCellStyle($hoja, 'F22:H28', $equipoMantenimiento->condiciones_fisicas ?? 'Sin condiciones fisicas especificadas', 14);

        // Titulo detalles extra del equipo
        $this->setCellStyle(
            $hoja,
            'B30:H30',
            'DETALLES EXTRA DEL EQUIPO',
            12,
            true,
            'FFFFFFFF', // blanco
            'FF305496', // azul
        );

        // datos detalle extra
        $this->setCellStyle($hoja, 'B31:H31', $equipoMantenimiento->detalles_equipo_extra ?? 'Sin detalles extra del equipo', 16);

        // Titulo trabajo a realizar
        $this->setCellStyle(
            $hoja,
            'B33:H33',
            $tipo === 'recepcion' ? 'TRABAJO A REALIZAR' : 'TRABAJO REALIZADO',
            12,
            true,
            'FFFFFFFF', // blanco
            'FF305496', // azul
        );

        // Iterar sobre las tareas a realizar y colocar las tareas desde B34
        $fila = 34;
        $tareas = $equipoMantenimiento->{$tipo === 'recepcion' ? 'trabajoARealizar' : 'trabajoRealizado'};
        if ($tareas->isEmpty()) {
            $this->setCellStyle($hoja, 'B' . $fila . ':H' . $fila, $tipo === 'recepcion' ? 'Sin tareas pendientes' : 'Sin tareas realizadas', 14);
            $fila++;
        } else {
            foreach ($tareas as $tarea) {
                $this->setCellStyle($hoja, 'B' . $fila . ':H' . $fila, $tarea->tarea_mantenimiento, 14); // Usar el campo correspondiente
                $fila++;
            }
        }


        // BORDES TAREAS
        $this->setBorders($hoja, 'B34:H' . $fila - 1);

        $hoja->getStyle('B34')->getAlignment()->setWrapText(true); // Habilitar ajuste de texto

        // Ajustar la fila para el siguiente contenido
        $fila++; // Aumentar la fila para el siguiente contenido

        // Titulo Costo servicio
        $this->setCellStyle(
            $hoja,
            'B' . $fila . ':E' . $fila,
            'COSTO DEL SERVICIO',
            12,
            true,
            'FFFFFFFF', // blanco
            'FF305496', // azul
        );
        // BORDES
        $this->setBorders($hoja, 'B' . $fila . ':E' . $fila);


        $this->setCellStyle($hoja, 'F' . $fila . '', 'TOTAL', 14, true);
        $this->setCellStyle($hoja, 'G' . $fila . '', 'A CUENTA', 14, true);
        $this->setCellStyle($hoja, 'H' . $fila . '', 'SALDO RESTANTE', 14, true);

        $this->setCellStyle($hoja, 'F' . ($fila + 1) . '', 'S/. ' . ($equipoMantenimiento->maintenance->total_mantenimiento ?? 'Sin total mantenimento asignado'), 16);
        $this->setCellStyle($hoja, 'G' . ($fila + 1) . '', 'S/. ' . $equipoMantenimiento->maintenance->adelanto_mantenimiento, 16);
        $this->setCellStyle($hoja, 'H' . ($fila + 1) . '', 'S/. ' . ($equipoMantenimiento->maintenance->saldo_restante ?? '-'), 16);
        // BORDES
        $this->setBorders($hoja, 'F' . $fila . ':' . 'H' . ($fila + 1), 'all');

        // Titulo Persona que recoge
        $fila += 3; // Aumentar la fila para el siguiente contenido
        $this->setCellStyle(
            $hoja,
            'B' . $fila . ':E' . $fila,
            'PERSONA QUE RECOGE',
            12,
            true,
            'FFFFFFFF', // blanco
            'FF305496', // azul
        );
        // BORDES
        $this->setBorders($hoja, 'B' . $fila . ':E' . $fila);

        $this->setCellStyle($hoja, 'F' . $fila . '', 'DNI', 14, true);
        $this->setCellStyle($hoja, 'F' . ($fila + 1) . '', 'NOMBRE', 14, true);
        $this->setCellStyle($hoja, 'F' . ($fila + 2) . '', 'TELEFONO', 14, true);

        // Verificar si clienteRecoge no es nulo antes de acceder a sus propiedades
        if ($equipoMantenimiento->maintenance->clienteRecoge) {
            $this->setCellStyle($hoja, 'G' . $fila . ':H' . $fila, $equipoMantenimiento->maintenance->clienteRecoge->identificacion_entidad, 16);
            $this->setCellStyle($hoja, 'G' . ($fila + 1) . ':H' . ($fila + 1), $equipoMantenimiento->maintenance->clienteRecoge->nombre_entidad, 16);
            $this->setCellStyle($hoja, 'G' . ($fila + 2) . ':H' . ($fila + 2), $equipoMantenimiento->maintenance->clienteRecoge->telefono_entidad, 16);

        }
        // BORDES
        $this->setBorders($hoja, 'F' . $fila . ':' . 'H' . ($fila + 2), 'all');

        // Titulo Tecnico Entrega
        $fila += 4; // Aumentar la fila para el siguiente contenido
        $this->setCellStyle(
            $hoja,
            'B' . $fila . ':D' . $fila,
            'TÉCNICO ENTREGA',
            12,
            true,
            'FFFFFFFF', // blanco
            'FF305496', // azul
        );
        // BORDES
        $this->setBorders($hoja, 'B' . $fila . ':D' . $fila);

        $this->setCellStyle($hoja, 'B' . ($fila + 3) . ':D' . ($fila + 3), 'ING. LUIS BAZALAR', 14);

        // BORDES
        $this->setBorders($hoja, 'B' . ($fila + 1) . ':D' . ($fila + 3));

        $this->setCellStyle(
            $hoja,
            'B' . ($fila + 4) . ':D' . ($fila + 4),
            'NOMBRE Y FIRMA',
            16,
            true,
            'FF000000', // negro
            'FFACB9CA', // gris claro
        );
        // BORDES
        $this->setBorders($hoja, 'B' . ($fila + 4) . ':D' . ($fila + 4));

        // Titulo Cliente Recepciona
        $this->setCellStyle(
            $hoja,
            'F' . $fila . ':H' . $fila,
            'CLIENTE RECEPCIONA',
            12,
            true,
            'FFFFFFFF', // blanco
            'FF305496', // azul
        );
        // BORDES
        $this->setBorders($hoja, 'F' . $fila . ':H' . $fila);

        // BORDES
        $this->setBorders($hoja, 'F' . ($fila + 1) . ':H' . ($fila + 3));

        $this->setCellStyle(
            $hoja,
            'F' . ($fila + 4) . ':H' . ($fila + 4),
            'FIRMA CONFORME',
            16,
            true,
            'FF000000', // negro
            'FFACB9CA', // gris claro
        );
        // BORDES
        $this->setBorders($hoja, 'F' . ($fila + 4) . ':H' . ($fila + 4));

        // CONFIGURACION DE BORDES
        $this->setBorders($hoja, 'F11:H13', 'all');
        $this->setBorders($hoja, 'B14:H18', 'all');
        $this->setBorders($hoja, 'B20:H28', 'all');
        $this->setBorders($hoja, 'B30:H31', 'all');
        $this->setBorders($hoja, 'B33:H33', 'all');

        // 6. Establecer el área de impresión
        $hoja->getPageSetup()->setPrintArea('A1:I' . ($fila + 5));

        // Asegúrate de que las celdas fuera del área de impresión mantengan su estilo
        // Esto se puede hacer aplicando el estilo de fondo blanco solo a las celdas que no tienen un fondo definido
        foreach (range('A', 'I') as $columnaID) {
            for ($rowID = 1; $rowID <= $fila + 5; $rowID++) {
                $celda = $columnaID . $rowID;
                if ($hoja->getStyle($celda)->getFill()->getFillType() === Fill::FILL_NONE) {
                    $hoja->getStyle($celda)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FFFFFFFF'); // Color de fondo blanco
                }
            }
        }

        // Ajustar el ancho de las columnas automáticamente
        foreach (range('A', 'H') as $columnaID) {
            $hoja->getColumnDimension($columnaID)->setAutoSize(true);
        }

        // Establecer la altura de todas las filas a 24
        foreach (range(1, $hoja->getHighestRow() + 1) as $rowID) {
            $hoja->getRowDimension($rowID)->setRowHeight(24);
        }

        // 7. Guarda el archivo como respuesta de descarga
        $writer = new Xlsx($spreadsheet);
        $nombreArchivo = ($tipo === 'recepcion' ? 'FormatoRecepcion_' : 'FormatoEntrega_') . $equipoMantenimiento->maintenance->cliente->nombre_entidad . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $nombreArchivo, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$nombreArchivo\"",
        ]);

    }

    private function formatearTareas($tareas)
    {
        if ($tareas->isEmpty()) {
            return "No hay tareas pendientes.";
        }

        $tareasTexto = '';

        foreach ($tareas as $tarea) {
            $tareasTexto .= "* " . $tarea->tarea_mantenimiento . "\n"; // Agrega cada tarea y un salto de línea
        }

        return $tareasTexto;
    }

    private function setCellStyle($hoja, $range, $value, $fontSize, $bold = false, $fontColor = "FF000000", $fillColor = "FFFFFFFF")
    {
        // Verifica si el rango contiene más de una celda para aplicar combinación
        if (strpos($range, ':') !== false) {
            $hoja->mergeCells($range); // Combina el rango si es necesario
        }

        // Establecer valor en la primera celda del rango
        $hoja->setCellValue(explode(':', $range)[0], $value); // Toma solo la primera celda del rango

        // Establecer estilo de fuente
        $hoja->getStyle($range)->getFont()
            ->setName('Calibri')
            ->setBold($bold)
            ->setSize($fontSize)
            ->getColor()->setARGB($fontColor); // Color de texto

        // Establecer color de fondo
        $hoja->getStyle($range)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB($fillColor); // Color de fondo

        // Establecer alineación
        $hoja->getStyle($range)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
    }

    private function setBorders($hoja, $range, $borderType = 'outer', $borderColor = 'FF000000', $borderStyle = Border::BORDER_THIN)
    {
        // Verifica si el rango es una única celda
        if (strpos($range, ':') === false) {
            $range .= ':' . $range; // Cambia "A1" a "A1:A1" para aplicar el borde correctamente
        }

        $borderStyleArray = [];

        if ($borderType === 'all') {
            // Establecer bordes en todas las direcciones
            $borderStyleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => $borderStyle, // Estilo del borde
                        'color' => ['argb' => $borderColor], // Color del borde
                    ],
                ],
            ];
        } elseif ($borderType === 'outer') {
            // Establecer solo bordes externos
            $borderStyleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => $borderStyle, // Estilo del borde externo
                        'color' => ['argb' => $borderColor], // Color del borde externo
                    ],
                ],
            ];
        }

        // Aplicar los bordes al rango
        $hoja->getStyle($range)->applyFromArray($borderStyleArray);
    }


}
