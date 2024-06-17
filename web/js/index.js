$(document).ready(function() {
    $('#enlaceVolver').click(function(e) {
        e.preventDefault();
        window.history.back(); 
    });

    $('.o-table').DataTable({
        "paging": true, 
        "searching": true 
    });

    
    $('.o-table__mark').each(function() {
        if ($(this).text() === "Super-admin") {
            $(this).addClass('--super-admin');
        } else if ($(this).text() === "admin") {
            $(this).addClass('--admin');
        } else if ($(this).text() === "user") {
            $(this).addClass('--user');
        }
    });

    $('#modalEditarGenero').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');

        var modal = $(this);
        modal.find('#editGeneroId').val(id);
        modal.find('#editGeneroNombre').val(nombre);
    });

    $('#formEditarGenero').on('submit', function(event) {
        event.preventDefault();

        var id = $('#editGeneroId').val();
        var nombre = $('#editGeneroNombre').val();

        $.ajax({
            url: 'index.php?action=editarGenero',
            method: 'POST',
            data: { id: id, nombre: nombre },
            dataType: 'json', 
            success: function(response) {
                if (response.success) {
                    $('#fila-genero-' + id + ' td:nth-child(1)').text(nombre);
                    $('#modalEditarGenero').modal('hide');
                } else {
                    alert('Error al actualizar el género');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud:', textStatus, errorThrown); // Para depuración
                alert('Error en la solicitud');
            }
        });
    });

    $('#modalEditarAutor').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var id = button.data('id');
        var nombre = button.data('nombre');
        var apellidos = button.data('apellidos');
        var biografia = button.data('biografia');
        var fechaNacimiento = button.data('fecha-nacimiento');
        var pais = button.data('pais');
        var foto = button.data('foto');
    
        // Asigna los valores a los campos del formulario de edición
        var modal = $(this);
        modal.find('#editAutorId').val(id);
        modal.find('#editAutorNombre').val(nombre);
        modal.find('#editAutorApellidos').val(apellidos);
        modal.find('#editAutorBiografia').val(biografia);
        modal.find('#editAutorFechaNacimiento').val(fechaNacimiento);
        modal.find('#editAutorPais').val(pais);
        // No se debe asignar el valor del input tipo file en este caso
    
        // Puedes añadir una vista previa de la imagen si es necesario
        var fotoPreview = modal.find('.editAutorFotoPreview');
        if (foto) {
            fotoPreview.attr('src', 'web/images/fotosAutores/' + foto);
        } else {
            // Puedes mostrar una imagen predeterminada si no hay foto
            fotoPreview.attr('src', 'ruta/a/imagen/por/defecto');
        }
    });
    
    $('#formEditarAutor').on('submit', function(event) {
        event.preventDefault();
    
        var id = $('#editAutorId').val();
        var nombre = $('#editAutorNombre').val();
        var apellidos = $('#editAutorApellidos').val();
        var biografia = $('#editAutorBiografia').val();
        var fechaNacimiento = $('#editAutorFechaNacimiento').val();
        var pais = $('#editAutorPais').val();
        var foto = $('#editAutorFoto').prop('files')[0]; 
    
        var formData = new FormData();
        formData.append('id', id);
        formData.append('nombre', nombre);
        formData.append('apellidos', apellidos);
        formData.append('biografia', biografia);
        formData.append('fechaNacimiento', fechaNacimiento);
        formData.append('pais', pais);
        formData.append('foto', foto); 
    
        $.ajax({
            url: 'index.php?action=editarAutor',
            method: 'POST',
            data: formData,
            processData: false, 
            contentType: false, 
            dataType: 'json',
            success: function(response) {
    
                if (response.success) {
                    // Actualizar los datos en la tabla sin recargar la página
                    $('#fila-autor-' + id + ' td:nth-child(2)').text(response.autor.nombre);
                    $('#fila-autor-' + id + ' td:nth-child(3)').text(response.autor.apellidos);
                    $('#fila-autor-' + id + ' td:nth-child(4)').text(response.autor.biografia);
                    $('#fila-autor-' + id + ' td:nth-child(5)').text(response.autor.fecha_nacimiento);
                    $('#fila-autor-' + id + ' td:nth-child(6)').text(response.autor.pais);
    
                    // Actualizar la imagen 
                    if (response.autor.foto) {
                        $('#fila-autor-' + id + ' td:nth-child(1)').find('img').attr('src', 'web/images/fotosAutores/' + response.autor.foto);
                    }
    
                    $('#modalEditarAutor').modal('hide');
                } else {
                    alert('Error al actualizar el autor');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud:', textStatus, errorThrown);
                alert('Error en la solicitud');
            }
        });
    });
    
    $('#modalEditarLibro').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var id = button.data('id');
        var titulo = button.data('titulo');
        var resumen = button.data('resumen');
        var isbn = button.data('isbn');
        var edicion = button.data('edicion');
        var idAutor = button.data('idAutor');
        var idGenero = button.data('idGenero');
        var foto = button.data('foto');
    
        var modal = $(this);
        modal.find('#editLibroId').val(id);
        modal.find('#editLibroTitulo').val(titulo);
        modal.find('#editLibroResumen').val(resumen);
        modal.find('#editLibroIsbn').val(isbn);
        modal.find('#editLibroEdicion').val(edicion);
        modal.find('#editLibroAutor').val(idAutor);
        modal.find('#editLibroGenero').val(idGenero);
    
    
        var fotoPreview = modal.find('.editLibroFotoPreview');
        if (foto) {
            fotoPreview.attr('src', 'web/images/fotosPortadas/' + foto);
        } else {

            fotoPreview.attr('src', ''); 
        }
    });
    $('#formEditarLibro').on('submit', function(event) {
        event.preventDefault();
        var id=$('#editLibroId').val();
        var titulo=$('#editLibroTitulo').val();
        var resumen=$('#editLibroResumen').val();
        var isbn=$('#editLibroIsbn').val();
        var edicion=$('#editLibroEdicion').val();
        var autor=$('#editLibroAutor').val();
        var genero=$('#editLibroGenero').val();

        var foto = $('#editLibroFoto').prop('files')[0]; 
        var formData = new FormData(this);

        formData.append('id', id);
        formData.append('titulo', titulo);
        formData.append('resumen', resumen);
        formData.append('isbn', isbn);
        formData.append('edicion', edicion);
        formData.append('autor', autor);
        formData.append('genero', genero);
        formData.append('foto', foto); 
    
        $.ajax({

            url: 'index.php?action=editarLibro', 
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType:'json',
            success: function(response) {

                if (response.success) {
                    var libro = response.libro;
                    var filaLibro = $('#fila-libro-' + libro.id);
                    
                    filaLibro.find('td:nth-child(3)').text(libro.nombre);
                    filaLibro.find('td:nth-child(2)').text(libro.apellidos);
                    filaLibro.find('td:nth-child(4)').text(libro.email);
                    filaLibro.find('td:nth-child(5)').text(libro.poblacion);
                    filaLibro.find('td:nth-child(6)').text(libro.rol);
    
                    // Actualizar la imagen 
                    if (libro.foto) {
                        filaLibro.find('td:nth-child(1)').find('img').attr('src', 'web/images/fotosPortadas/' + libro.foto);
                    }
    
                    $('#modalEditarLibro').modal('hide');
                } else {
                    alert('Error al actualizar el libro');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud:', textStatus, errorThrown);
                console.log(jqXHR.responseText)
                alert('Error en la solicitud');
            }
        });
    });
    

    $('#modalEditarUsuario').on('show.bs.modal', function(event){
        var button=$(event.relatedTarget);
        var id=button.data('id');
        var nombre = button.data('nombre');
        var apellidos = button.data('apellidos');
        var email=button.data('email');
        var foto=button.data('foto');
        var poblacion=button.data('poblacion');
        var rol=button.data('rol');

        var modal=$(this);
        modal.find('#editUsuarioId').val(id);
        modal.find('#editUsuarioNombre').val(nombre);
        modal.find('#editUsuarioApellidos').val(apellidos);
        modal.find('#editUsuarioEmail').val(email);
        modal.find('#editUsuarioPoblacion').val(poblacion);
        modal.find('#editUsuarioRol').val(rol);
    })
    
    $('#formEditarUsuario').on('submit', function(event){
        event.preventDefault();
        var id=$('#editUsuarioId').val();
        var nombre=$('#editUsuarioNombre').val();
        var apellidos=$('#editUsuarioApellidos').val();
        var email=$('#editUsuarioEmail').val();
        var poblacion=$('#editUsuarioPoblacion').val();
        var rol=$('#editUsuarioRol').val();

        var foto = $('#editUsuarioFoto').prop('files')[0]; 

        var formData = new FormData();
        formData.append('id', id);
        formData.append('nombre', nombre);
        formData.append('apellidos', apellidos);
        formData.append('email', email);
        formData.append('poblacion', poblacion);
        formData.append('rol', rol);
        formData.append('foto', foto); 

        $.ajax({
            url: 'index.php?action=editarUsuario',
            method: 'POST',
            data: formData,
            processData: false, 
            contentType: false, 
            dataType: 'json',
            success: function(response) {
    
                if (response.success) {
                    // Actualizar los datos en la tabla sin recargar la página
                    var usuario = response.usuario;
                    var filaUsuario = $('#fila-usuario-' + usuario.id);
                    
                    filaUsuario.find('td:nth-child(3)').text(usuario.nombre);
                    filaUsuario.find('td:nth-child(2)').text(usuario.apellidos);
                    filaUsuario.find('td:nth-child(4)').text(usuario.email);
                    filaUsuario.find('td:nth-child(5)').text(usuario.poblacion);
                    filaUsuario.find('td:nth-child(6)').text(usuario.rol);
    
                    // Actualizar la imagen 
                    if (usuario.foto) {
                        filaUsuario.find('td:nth-child(1)').find('img').attr('src', 'web/images/fotosUsuarios/' + usuario.foto);
                    }
    
                    $('#modalEditarUsuario').modal('hide');
                } else {
                    alert('Error al actualizar el usuario');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud:', textStatus, errorThrown);
                console.log(jqXHR.responseText)
                alert('Error en la solicitud');
            }
        });

    }) 
        
        
        
        $('.agregar-prestamo').on('click', function() {
            var botonPrestamo = $(this);
            var libroId = botonPrestamo.data('libro-id');
        
            $.ajax({
                url: 'index.php?action=efectuarPrestamo',
                type: 'POST',
                data: { libro_id: libroId },
                dataType: 'json', 
                success: function(response) {
                    if (response.success) {
                        botonPrestamo.text('¡Pasa a recogerlo en una hora!').prop('disabled', true);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Inicia sesión para efectuar el prestamo');
                    console.log(jqXHR.responseText); 
                }
            });
        });
        $(document).on('submit', 'form.devolver-libro-form', function(event) {
            event.preventDefault(); 
            var form = $(this); 
            var prestamoId = form.find('input[name="prestamo_id"]').val(); 
    
            
            $.ajax({
                url: form.attr('action'), 
                type: 'POST',
                data: form.serialize(), 
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                       
                        var row = form.closest('tr');
                        row.find('td:eq(3)').text(response.fecha_devolucion);
                        row.find('td:eq(4)').text('devuelto');
                        form.find('button[type="submit"]').remove(); 
    
                    } else {
                        alert('Error al devolver el libro: ' + response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error en la solicitud: ' + errorThrown);
                }
            });
        });
        
});
