<?php

class Autor{
    private $id;
    private $nombre;
    private $apellidos;
    private $foto;
    private $biografia;
    private $fecha_nacimiento;
    private $pais;
    

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
     * Get the value of nombre
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre($nombre): self {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Get the value of apellidos
     */
    public function getApellidos() {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     */
    public function setApellidos($apellidos): self {
        $this->apellidos = $apellidos;
        return $this;
    }

    /**
     * Get the value of foto
     */
    public function getFoto() {
        return $this->foto;
    }

    /**
     * Set the value of foto
     */
    public function setFoto($foto): self {
        $this->foto = $foto;
        return $this;
    }

    /**
     * Get the value of biografia
     */
    public function getBiografia() {
        return $this->biografia;
    }

    /**
     * Set the value of biografia
     */
    public function setBiografia($biografia): self {
        $this->biografia = $biografia;
        return $this;
    }

    /**
     * Get the value of fecha_nacimiento
     */
    public function getFechaNacimiento() {
        return $this->fecha_nacimiento;
    }

    /**
     * Set the value of fecha_nacimiento
     */
    public function setFechaNacimiento($fecha_nacimiento): self {
        $this->fecha_nacimiento = $fecha_nacimiento;
        return $this;
    }

    /**
     * Get the value of pais
     */
    public function getPais() {
        return $this->pais;
    }

    /**
     * Set the value of pais
     */
    public function setPais($pais): self {
        $this->pais = $pais;
        return $this;
    }
}