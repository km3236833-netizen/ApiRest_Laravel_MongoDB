<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
 * Obtiene todos los libros de la base de datos
 * 
 * Para qué: Mostrar listado completo de libros
 * 
 * @return \Illuminate\Http\JsonResponse
 * 
 * Libro::all() → Trae todos los registros de la tabla libros
 * response()->json() → Convierte los datos a formato JSON
 * 200 → Código de estado HTTP que significa "OK - Todo bien, solicitud exitosa"
 *       Se usa cuando la operación de consulta fue exitosa
 */
public function index()
{
    $libros = Libro::all(); // Obtiene todos los libros
    return response()->json($libros, 200); // Retorna JSON con código 200 (OK)
}

/**
 * Crea un nuevo libro en la base de datos
 * 
 * Para qué: Guardar un libro nuevo cuando el usuario envía datos
 * 
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\JsonResponse
 * 
 * $request->validate() → Valida que los datos cumplan las reglas
 * 'required' → Campo obligatorio, debe venir en la petición
 * 'string' → Debe ser texto
 * 'integer' → Debe ser número entero
 * 'nullable' → Campo opcional, puede venir vacío
 * 'max:255' → Máximo 255 caracteres
 * Libro::create() → Inserta el nuevo registro en la base de datos
 * 201 → Código de estado HTTP que significa "Created - Recurso creado con éxito"
 *       Se usa cuando se crea algo nuevo en la base de datos
 */
public function store(Request $request)
{
    // Valida los datos recibidos (según tu migración)
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',      // Título obligatorio
        'autor' => 'required|string|max:255',       // Autor obligatorio
        'genero' => 'nullable|string|max:255',      // Género opcional
        'anio_publicacion' => 'nullable|integer',   // Año opcional, debe ser número
    ]);
    
    // Crea el libro en la base de datos
    $libro = Libro::create($validated);
    
    // Retorna el libro creado con código 201 (Created)
    return response()->json($libro, 201);
}
/**
 * Muestra un libro específico por su ID
 * 
 * Para qué: Ver los detalles completos de un libro en particular
 * 
 * @param int $id
 * @return \Illuminate\Http\JsonResponse
 * 
 * findOrFail($id) → "Encuentra o falla"
 *   - Busca el registro por ID
 *   - Si lo encuentra: lo retorna
 *   - Si NO existe: lanza automáticamente error 404
 * 200 → Código de estado HTTP que significa "OK - Todo bien"
 *       Se usa cuando encontramos y retornamos el recurso correctamente
 */
public function show($id)
{
    // Busca el libro por ID, si no existe retorna error 404 automáticamente
    $libro = Libro::findOrFail($id);
    
    // Retorna el libro encontrado con código 200 (OK)
    return response()->json($libro, 200);
}
/**
 * Actualiza un libro existente
 * 
 * Para qué: Modificar los datos de un libro que ya existe
 * 
 * @param \Illuminate\Http\Request $request
 * @param int $id
 * @return \Illuminate\Http\JsonResponse
 * 
 * findOrFail($id) → Busca el libro, si no existe retorna 404
 * $libro->update() → Actualiza los campos en la base de datos
 * Validaciones sin 'required' → Los campos son opcionales al actualizar
 *   (puedes actualizar solo el título sin enviar el autor, por ejemplo)
 * 200 → Código de estado HTTP que significa "OK - Actualización exitosa"
 *       Se usa cuando modificamos un recurso correctamente
 */
public function update(Request $request, $id)
{
    // Busca el libro, si no existe retorna 404
    $libro = Libro::findOrFail($id);
    
    // Valida los datos (todos opcionales porque puedes actualizar solo algunos campos)
    $validated = $request->validate([
        'titulo' => 'string|max:255',           // Título opcional
        'autor' => 'string|max:255',            // Autor opcional
        'genero' => 'nullable|string|max:255',  // Género opcional
        'anio_publicacion' => 'nullable|integer', // Año opcional
    ]);
    
    // Actualiza el libro con los nuevos datos
    $libro->update($validated);
    
    // Retorna el libro actualizado con código 200 (OK)
    return response()->json($libro, 200);
}
/**
 * Elimina un libro de la base de datos
 * 
 * Para qué: Borrar permanentemente un libro
 * 
 * @param int $id
 * @return \Illuminate\Http\JsonResponse
 * 
 * findOrFail($id) → Busca el libro, si no existe retorna 404
 * $libro->delete() → Elimina el registro de la base de datos
 * 204 → Código de estado HTTP que significa "No Content - Sin contenido"
 *       Se usa cuando eliminamos algo exitosamente
 *       No hay contenido que retornar porque el recurso ya no existe
 */
public function destroy($id)
{
    // Busca el libro, si no existe retorna 404
    $libro = Libro::findOrFail($id);
    
    // Elimina el libro de la base de datos
    $libro->delete();
    
    // Retorna respuesta vacía con código 204 (No Content)
    return response()->json(null, 204);
}
}
