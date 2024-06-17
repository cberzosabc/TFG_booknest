<?php

class Prestamo {
    private $id;
    private $fechaPrestamo;
    private $fechaDevolucion;
    private $usuarioId;
    private $libroId;
    private $estado;

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
     * Get the value of fechaPrestamo
     */
    public function getFechaPrestamo() {
        return $this->fechaPrestamo;
    }

    /**
     * Set the value of fechaPrestamo
     */
    public function setFechaPrestamo($fechaPrestamo): self {
        $this->fechaPrestamo = $fechaPrestamo;
        return $this;
    }

    /**
     * Get the value of fechaDevolucion
     */
    public function getFechaDevolucion() {
        return $this->fechaDevolucion;
    }

    /**
     * Set the value of fechaDevolucion
     */
    public function setFechaDevolucion($fechaDevolucion): self {
        $this->fechaDevolucion = $fechaDevolucion;
        return $this;
    }

    /**
     * Get the value of usuarioId
     */
    public function getUsuarioId() {
        return $this->usuarioId;
    }

    /**
     * Set the value of usuarioId
     */
    public function setUsuarioId($usuarioId): self {
        $this->usuarioId = $usuarioId;
        return $this;
    }

    /**
     * Get the value of libroId
     */
    public function getLibroId() {
        return $this->libroId;
    }

    /**
     * Set the value of libroId
     */
    public function setLibroId($libroId): self {
        $this->libroId = $libroId;
        return $this;
    }

    /**
     * Get the value of estado
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Set the value of estado
     */
    public function setEstado($estado): self {
        $this->estado = $estado;
        return $this;
    }
}