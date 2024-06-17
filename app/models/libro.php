<?php

class Libro{
    private $id;
    private $titulo;
    private $resumen;
    private $isbn;
    private $edicion;
    private $editorial;
    private $foto_portada;
    private $id_autor;
    private $id_genero;
    private $portada;
    /**
     * Get the value of id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of titulo
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     */
    public function setTitulo($titulo): self {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Get the value of resumen
     */
    public function getResumen() {
        return $this->resumen;
    }

    /**
     * Set the value of resumen
     */
    public function setResumen($resumen): self {
        $this->resumen = $resumen;
        return $this;
    }

    /**
     * Get the value of isbn
     */
    public function getIsbn() {
        return $this->isbn;
    }

    /**
     * Set the value of isbn
     */
    public function setIsbn($isbn): self {
        $this->isbn = $isbn;
        return $this;
    }

    /**
     * Get the value of edicion
     */
    public function getEdicion() {
        return $this->edicion;
    }

    /**
     * Set the value of edicion
     */
    public function setEdicion($edicion): self {
        $this->edicion = $edicion;
        return $this;
    }

    /**
     * Get the value of editorial
     */
    public function getEditorial() {
        return $this->editorial;
    }

    /**
     * Set the value of editorial
     */
    public function setEditorial($editorial): self {
        $this->editorial = $editorial;
        return $this;
    }

    /**
     * Get the value of foto_portada
     */
    public function getFotoPortada() {
        return $this->foto_portada;
    }

    /**
     * Set the value of foto_portada
     */
    public function setFotoPortada($foto_portada): self {
        $this->foto_portada = $foto_portada;
        return $this;
    }

    /**
     * Get the value of id_autor
     */
    public function getIdAutor() {
        return $this->id_autor;
    }

    /**
     * Set the value of id_autor
     */
    public function setIdAutor($id_autor): self {
        $this->id_autor = $id_autor;
        return $this;
    }

    /**
     * Get the value of id_genero
     */
    public function getIdGenero() {
        return $this->id_genero;
    }

    /**
     * Set the value of id_genero
     */
    public function setIdGenero($id_genero): self {
        $this->id_genero = $id_genero;
        return $this;
    }

    /**
     * Get the value of portada
     */
    public function getPortada() {
        return $this->portada;
    }

    /**
     * Set the value of portada
     */
    public function setPortada($portada): self {
        $this->portada = $portada;
        return $this;
    }
}