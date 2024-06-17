<?php 

class libroDAO{
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn=$conn;
    }

    public function insert(Libro $libro): int|bool{
        if (!$stmt = $this->conn->prepare("INSERT INTO libro (titulo, resumen, isbn, edicion, foto_portada, id_autor, id_genero) VALUES (?,?,?,?,?,?,?)")) {
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }

        $titulo=$libro->getTitulo();
        $resumen=$libro->getResumen();
        $isbn=$libro->getIsbn();
        $edicion=$libro->getEdicion();
        $foto=$libro->getFotoPortada();
        $autor=$libro->getIdAutor();
        $genero=$libro->getIdGenero();
        $stmt->bind_param('ssiisii', $titulo, $resumen, $isbn, $edicion, $foto, $autor, $genero);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    public function getAllBooks(){
        try {
            $sql = "SELECT 
            libro.id, libro.titulo, libro.isbn, libro.edicion, libro.resumen, libro.foto_portada, libro.portada,libro.disponible,
            autor.nombre AS autor_nombre, autor.apellidos AS autor_apellidos,
            genero.nombre AS genero_nombre
        FROM 
            libro
        JOIN 
            autor ON libro.id_autor = autor.id
        JOIN 
            genero ON libro.id_genero = genero.id";
            $stmt = $this->conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Failed to prepare statement: ' . $this->conn->error);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result === false) {
                throw new Exception('Failed to get result: ' . $this->conn->error);
            }

            $books = [];
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }

            return $books;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function getLibrosPorAutor($autorId)
    {
        try {
            $sql = "SELECT 
                        libro.id, libro.titulo, libro.isbn, libro.edicion, libro.resumen, libro.foto_portada, libro.disponible, 
                        autor.nombre AS autor_nombre, autor.apellidos AS autor_apellidos,
                        genero.nombre AS genero_nombre
                    FROM 
                        libro
                    JOIN 
                        autor ON libro.id_autor = autor.id
                    JOIN 
                        genero ON libro.id_genero = genero.id
                    WHERE 
                        autor.id = ?";
            $stmt = $this->conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Failed to prepare statement: ' . $this->conn->error);
            }

            $stmt->bind_param("i", $autorId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result === false) {
                throw new Exception('Failed to get result: ' . $this->conn->error);
            }

            $libros = [];
            while ($row = $result->fetch_assoc()) {
                $libros[] = $row;
            }

            return $libros;
        } catch (Exception $e) {
            // Manejo de errores generales
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function getLibrosPorGenero($generoId)
    {
        try {
            $sql = "SELECT 
                        libro.id, libro.titulo, libro.isbn, libro.edicion, libro.resumen, libro.foto_portada, libro.disponible, 
                        autor.nombre AS autor_nombre, autor.apellidos AS autor_apellidos,
                        genero.nombre AS genero_nombre
                    FROM 
                        libro
                    JOIN 
                        autor ON libro.id_autor = autor.id
                    JOIN 
                        genero ON libro.id_genero = genero.id
                    WHERE 
                        genero.id = ?";
            $stmt = $this->conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Failed to prepare statement: ' . $this->conn->error);
            }

            $stmt->bind_param("i", $generoId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result === false) {
                throw new Exception('Failed to get result: ' . $this->conn->error);
            }

            $libros = [];
            while ($row = $result->fetch_assoc()) {
                $libros[] = $row;
            }

            return $libros;
        } catch (Exception $e) {
            // Manejo de errores generales
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function eliminarLibro($idLibro): bool {
        if (!$stmt = $this->conn->prepare("DELETE FROM libro WHERE id=?")) {
            echo "Error en la SQL: " . $this->conn->error;
            return false; 
        }
    
        $stmt->bind_param("i", $idLibro);
        if ($stmt->execute()) {
            return true;
        } else {
            return false; 
        }
    }
    public function marcarComoPortada($idLibro): bool {
        if (!$stmt = $this->conn->prepare("UPDATE libro SET portada = 1 WHERE id = ?")) {
            echo "Error al preparar la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("i", $idLibro);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al marcar como portada: " . $stmt->error;
            return false;
        }
    }

    public function desmarcarComoPortada($idLibro): bool {
        if (!$stmt = $this->conn->prepare("UPDATE libro SET portada = 0 WHERE id = ?")) {
            echo "Error al preparar la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("i", $idLibro);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al desmarcar como portada: " . $stmt->error;
            return false;
        }
    }
    public function getLibrosPortada() {
        try {
            $sql = "SELECT 
                        libro.id, libro.titulo, libro.isbn, libro.edicion, libro.resumen, libro.foto_portada, libro.disponible, 
                        autor.nombre AS autor_nombre, autor.apellidos AS autor_apellidos,
                        genero.nombre AS genero_nombre
                    FROM 
                        libro
                    JOIN 
                        autor ON libro.id_autor = autor.id
                    JOIN 
                        genero ON libro.id_genero = genero.id
                    WHERE 
                        libro.portada = 1"; // Filtro para obtener solo los libros marcados como portada
            $stmt = $this->conn->prepare($sql);
    
            if ($stmt === false) {
                throw new Exception('Failed to prepare statement: ' . $this->conn->error);
            }
    
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result === false) {
                throw new Exception('Failed to get result: ' . $this->conn->error);
            }
    
            $librosPortada = [];
            while ($row = $result->fetch_assoc()) {
                $librosPortada[] = $row;
            }
    
            return $librosPortada;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    public function update(Libro $libro): bool {
        $id = $libro->getId();
        $titulo = $libro->getTitulo();
        $resumen = $libro->getResumen();
        $isbn = $libro->getIsbn();
        $edicion = $libro->getEdicion();
        $idAutor = $libro->getIdAutor();
        $idGenero = $libro->getIdGenero();
        $foto = $libro->getFotoPortada();
        $sql = "UPDATE libro SET titulo=?, resumen=?, isbn=?, edicion=?, id_autor=?, id_genero=?, foto_portada=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            echo "Error al preparar la consulta " . $this->conn->error;
            return false;
        }
    
        // El orden y los tipos en bind_param deben coincidir con los tipos y el orden de los parámetros en el query SQL
        $stmt->bind_param('sssiiisi', $titulo, $resumen, $isbn, $edicion, $idAutor, $idGenero, $foto, $id);
    
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al ejecutar la consulta " . $stmt->error;
            return false;
        }
    }
    

    public function findById($id){
        $sql = "SELECT * FROM libro WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            echo "Error al preparar la consulta: " . $this->conn->error;
            return null;
        }

        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            return null;
        }

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo "No se encontró el libro con ID: {$id}";
            return null;
        }

        $libro = $result->fetch_assoc();
        return $libro;
    }

    public function checkDisponibilidad($idLibro) {
        $sql = "SELECT disponible FROM libro WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            echo "Error al preparar la consulta: " . $this->conn->error;
            return false;
        }
    
        $stmt->bind_param('i', $idLibro);
        if (!$stmt->execute()) {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            return false;
        }
    
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return false;
        }
    
        $libro = $result->fetch_assoc();
        return (bool)$libro['disponible'];
    }

    public function marcarComoNoDisponible($idLibro): bool {
        $sql = "UPDATE libro SET disponible = 0 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            echo "Error al preparar la consulta: " . $this->conn->error;
            return false;
        }
    
        $stmt->bind_param('i', $idLibro);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            return false;
        }
    }

    

}