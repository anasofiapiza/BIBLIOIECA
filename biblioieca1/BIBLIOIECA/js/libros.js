document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const librosRecomendados = document.getElementById('libros-recomendados');
    const librosResultados = document.getElementById('libros-resultados');
    const loader = document.getElementById('loader');
    const panelInfo = document.createElement('div');
    const suggestionsContainer = document.getElementById('suggestions-container');
    document.body.appendChild(panelInfo);
    panelInfo.id = 'panel-info';
    panelInfo.style.display = 'none';


    const libros = [
        {
            titulo: 'Franklin siembra un arbol',
            autor: 'Paulette Bourgeois',
            fecha: '2010',
            imagen: 'https://www.librerianorma.com/images/Caratula/Responsive/9789584507280.jpg',
            introduccion: 'Es un cuento infantil donde Franklin aprende el valor de cuidar el medio ambiente. A través de la siembra y el cuidado de un árbol, la historia enseña a los niños la importancia del compromiso, la paciencia y el respeto por la naturaleza..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'el hàmster jaime y la fiesta de cumpleaños',
            autor: ' Raoul Krischanitz',
            fecha: '2003',
            imagen: 'https://www.libreriacasatomada.com/imagenes/7706894/770689410662.GIF',
            introduccion: ' Relata la aventura de Jaime y sus amigos mientras organizan una fiesta de cumpleaños. Con ilustraciones coloridas y un lenguaje sencillo, el libro transmite valores como la amistad, la cooperación y la alegría de compartir momentos con los seres queridos..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'El nuevo amigo de franklin',
            autor: 'Paulette Bourgeois ',
            fecha: '1997',
            imagen: 'https://www.leoteca.es/img/libros/1031/9789580449874-L.jpg',
            introduccion: 'En esta historia, Franklin conoce a Don, un burro con el que aprende a superar sus miedos y a aceptar las diferencias. El cuento enseña valores de amistad, comprensión y aceptación de quienes son distintos a nosotros..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Fernando furioso',
            autor: ' Hiawyn Oram ',
            fecha: '2010',
            imagen: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQsV0pWMu4UY1DbYs972Ibah-U8ChepUrCuVA&s',
            introduccion: 'Este libro narra la historia de Fernando, un niño con mal genio que aprende a controlar su ira y comprender el impacto de sus emociones en los demás. Es un relato que enseña a los niños a manejar la rabia con paciencia y reflexión, favoreciendo la resolución de conflictos de manera positiva..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Toda mafalda',
            autor: 'Joaquín Salvador Lavado Tejón',
            fecha: '1932',
            imagen: 'https://images.cdn2.buscalibre.com/fit-in/360x360/e6/b4/e6b4c842c7f7974dfd9431740d66734e.jpg',
            introduccion: 'Toda Mafalda es una recopilación completa de las historietas creadas por Quino, protagonizadas por Mafalda, una niña curiosa y crítica que reflexiona con humor sobre temas sociales, políticos y culturales. El libro reúne sus pensamientos agudos y su visión del mundo, convirtiéndose en un ícono del pensamiento latinoamericano.',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Carlos gorostiza Teatro 5',
            autor: 'carlos gorostiza',
            fecha: '1949',
            imagen: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRYCDZR9__yeNiWc1p61D99L6dO9vTess4ulQ&s',
            introduccion: 'Esta obra reúne tres piezas teatrales (Los otros papeles, A propósito del tiempo y Doble historia de amor) donde el autor explora con profundidad la identidad, el paso del tiempo y los vínculos humanos. Su estilo íntimo y reflexivo convierte el libro en una valiosa muestra del teatro argentino contemporáneo y del talento de uno de sus dramaturgos más destacados..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Aladino y la lámpara maravillosa',
            autor: ' Antoine Galland.',
            fecha: '1867',
            imagen: 'https://lh5.googleusercontent.com/proxy/scQpGZklDIkQ0BBcMQOR6ro0WbJSG-ivs5ZjlWWev38EloJ5IZLpCs1cHsSDqJjFLP7gGv-Tl8AIUPUrjsgUsFRTTt0f1Xuk7cCSINtsM9kJdKsxFoDQt6dhaTZewNcvN5Hs9nwqIhSGmlG7Ghr2RdgoZDvPHXsEjQJw9a6MyH0Rum8UYWJfLmz2xodqYWMf44cgJpsGMprbReYpFX_7Gd8sCKn2Ipji',
            introduccion: 'Es un cuento clásico de Las mil y una noches que narra la historia de Aladino, un joven humilde que encuentra una lámpara mágica. Al frotarla, aparece un genio poderoso que le concede deseos. Gracias a su astucia y al genio, Aladino enfrenta a un malvado mago, logra superar obstáculos y finalmente obtiene la mano de una princesa..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Entornos naturales 3 laboratorios',
            autor: 'Casa del Saber (Santillana)',
            fecha: '2016',
            imagen: 'https://i.calameoassets.com/191107155540-126a0979fa52576d853af8d475de6c3e/large.jpg',
            introduccion: ' es un libro escolar diseñado para estudiantes de primaria. Presenta de forma sencilla y visual temas sobre los seres vivos, el cuerpo humano, el medio ambiente y los fenómenos naturales. Incluye actividades, ilustraciones y experimentos que buscan despertar la curiosidad científica en los niños y fomentar el cuidado de la naturaleza..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Quimica 1',
            autor: 'editorial de Santillana.',
            fecha: '2010',
            imagen: 'https://imgv2-1-f.scribdassets.com/img/document/650688308/original/0cbc4eb01e/1?v=1',
            introduccion: 'Es un libro de texto escolar que introduce a los estudiantes en los fundamentos de la química. Explica conceptos básicos como la estructura de la materia, enlaces químicos, propiedades, reacciones y el papel de la química en la vida cotidiana. Además, incluye prácticas de laboratorio para reforzar el aprendizaje experimental y el pensamiento científico..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'La quimica energia para la vida',
            autor: 'Ministerio del Poder Popular para la Educación.',
            fecha: '2012',
            imagen: 'https://guao.org/sites/default/files/biblioteca/Ciencias%20Naturales%2C%20Tomo%20I%2C%204to%20a%C3%B1o.%20Energ%C3%ADa%20para%20la%20vida.png',
            introduccion: 'es un libro escolar diseñado para estudiantes de cuarto año de educación media. Aborda temas de biología, química, física y medio ambiente, con un enfoque integral que relaciona la ciencia con la vida diaria, la cultura y el entorno natural. Su propósito es fomentar el pensamiento crítico, el aprendizaje práctico y el compromiso con la preservación de la naturaleza..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Ciencia experimental biologia',
            autor: 'María Helena Jaramillo',
            fecha: '2010',
            imagen: 'https://imgv2-1-f.scribdassets.com/img/document/556522325/298x396/2d7c43c9fe/1710573117?v=1',
            introduccion: 'Es un texto escolar de la serie Ciencias Naturales y Educación Ambiental para educación básica secundaria y media. Integra contenidos de biología, química y física de manera práctica, con actividades y proyectos que buscan desarrollar competencias científicas, ciudadanas y laborales. Está diseñado para fomentar el pensamiento crítico, la experimentación y la aplicación de la ciencia en la vida cotidiana..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Quimica y ambiente 2',
            autor: ' Fidel Antonio Cárdenas S. y Carlos Arturo Gélvez S.',
            fecha: '2011',
            imagen: 'https://www.editorialbruno.com.pe/bstore/983/mc-graw-hill-quimica-y-ambiente-2.jpg',
            introduccion: ' Este libro está dirigido a estudiantes de educación media y busca explicar los conceptos fundamentales de la química en relación con el medio ambiente. A través de un enfoque práctico, relaciona los procesos químicos con situaciones de la vida cotidiana y promueve la conciencia ambiental. Incluye actividades y recursos pedagógicos que refuerzan el aprendizaje científico aplicado..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Learning together English',
            autor: ': Luciana Renda B. de Melo, Marcelo Baccarin, Ronaldo Lima Jr.',
            fecha: '2018',
            imagen: 'https://http2.mlstatic.com/D_NQ_NP_957921-MLA82982094855_032025-O.webp',
            introduccion: ' Es un libro de inglés para educación primaria que busca enseñar el idioma de manera progresiva y divertida. Incluye actividades dinámicas, juegos y ejercicios de comunicación que fomentan el aprendizaje colaborativo y el desarrollo de habilidades orales y escritas en inglés..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Basic English grammar ',
            autor: ' Howard Sargeant.',
            fecha: '2007',
            imagen: 'https://m.media-amazon.com/images/I/51jUMPwkZvL._UF1000,1000_QL80_.jpg',
            introduccion: '  es un libro de gramática inglesa para principiantes (grados 5-8), publicado por Saddleback Educational Publishing en 2007. Ofrece explicaciones claras y concisas de las reglas gramaticales básicas, como sustantivos, pronombres, verbos, tiempos verbales y estructura de oraciones, con ejemplos y notas de ayuda para facilitar el aprendizaje en estudiantes de inglés como segunda lengua..',
            disponible: true // Añadido para gestionar el préstamo

        },
        {
            titulo: 'Be happy',
            autor: ' Monica Sheehan',
            fecha: '2007',
            imagen: 'https://d28hgpri8am2if.cloudfront.net/book_images/cvr9781442498570/be-happy!-9781442498570_lg.jpg',
            introduccion: 'El libro Be Happy! de Monica Sheehan presenta una portada alegre y llamativa, protagonizada por un perro sonriente que hace malabares con bolas de colores mientras se sostiene en una sola pata. Con un fondo blanco y una franja lateral negra con lunares blancos, transmite una sensación de optimismo y diversión..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Follow me',
            autor: ' Barry Tomalin.',
            fecha: '1983',
            imagen: 'https://images.cdn1.buscalibre.com/fit-in/360x360/2e/21/2e211573f7857874c7a38a6b8ce786e4.jpg',
            introduccion: ' El libro Follow Me y habla inglés 1 es una guía práctica para aprender inglés desde cero, especialmente pensada para hispanohablantes. Forma parte de una serie educativa producida por BBC English y cubre las unidades 1 a 15. Su enfoque es progresivo y estructurado, ideal para quienes desean adquirir vocabulario básico, mejorar la pronunciación y comenzar a comunicarse en situaciones cotidianas..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Ciencias exploremos la naturaleza',
            autor: 'Leslie Yaneth Leal Mejía',
            fecha: '2019',
            imagen: 'https://www.librerianorma.com/images/Caratula/Responsive/9789580007388.jpg',
            introduccion: 'El libro Ciencias Naturales – Grado 6 de la serie Exploradores es un texto escolar diseñado para estudiantes de sexto grado. Su enfoque es despertar la curiosidad por el mundo natural a través del estudio de animales, plantas, ecosistemas y fenómenos científicos. Con ilustraciones llamativas y contenidos adaptados a la edad, busca fomentar el pensamiento crítico y el respeto por la naturaleza, integrando actividades que promueven la observación, la experimentación y el aprendizaje activo..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Educar en la naturaleza ',
            autor: 'Gustavo Ariel Cerda, Rozo',
            fecha: 'anonimo',
            imagen: 'https://imgv2-1-f.scribdassets.com/img/document/701502471/original/237e9ae53b/1?v=1',
            introduccion: ' El libro Misión 3 Naturaleza está diseñado para estudiantes de tercer grado y tiene como objetivo fomentar el aprendizaje sobre el entorno natural. A través de actividades educativas y contenidos visuales, invita a los niños a explorar la biodiversidad, comprender la importancia de cuidar el medio ambiente y desarrollar una conexión respetuosa con la naturaleza..',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'Anna Karenina',
            autor: 'León Tolstói',
            fecha: '1877',
            imagen: 'https://www.elejandria.com/covers/Ana_Karenina-Tolstoi_Leon-md.png',
            introduccion: 'Una novela que explora las complejidades del amor, el matrimonio y la sociedad rusa del siglo XIX a través de la historia de Anna Karenina y otros personajes.',
            disponible: true // Añadido para gestionar el préstamo
        },
        {
            titulo: 'El gran Gatsby',
            autor: 'F. Scott Fitzgerald',
            fecha: '1925',
            imagen: 'data:image/jpeg;base64,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',
            introduccion: 'Una crítica al Sueño Americano ambientada en los años 20, siguiendo la vida del misterioso millonario Jay Gatsby y su obsesión con un amor del pasado.',
            disponible: true // Añadido para gestionar el préstamo
        }
    ];


    function mostrarLibros(libros, contenedor) {
        contenedor.innerHTML = '';
        libros.forEach(libro => {
            const libroElement = document.createElement('div');
            libroElement.classList.add('libro');
            // Añadido un atributo data-libro-id, asumiendo que el título es un id único temporalmente
            libroElement.setAttribute('data-libro-id', libro.titulo); 
            libroElement.innerHTML = `
                <img src="${libro.imagen}" alt="${libro.titulo}">
                <div class="libro-info">
                    <h3>${libro.titulo}</h3>
                    <p>${libro.autor}</p>
                    <p>${libro.fecha}</p>
                </div>
            `;


            libroElement.addEventListener('click', () => {
                mostrarPanelLibro(libro);
            });


            contenedor.appendChild(libroElement);
        });
    }


    mostrarLibros(libros, librosRecomendados);


    function buscarLibros(query) {
        return libros.filter(libro =>
            libro.titulo.toLowerCase().includes(query.toLowerCase()) ||
            libro.autor.toLowerCase().includes(query.toLowerCase()) ||
            libro.fecha.includes(query)
        );
    }


    function mostrarSugerencias(sugerencias) {
        suggestionsContainer.innerHTML = '';
        sugerencias.forEach(sugerencia => {
            const sugerenciaElement = document.createElement('div');
            sugerenciaElement.classList.add('sugerencia');
            sugerenciaElement.textContent = sugerencia.titulo;
            sugerenciaElement.addEventListener('click', () => {
                searchInput.value = sugerencia.titulo;
                suggestionsContainer.innerHTML = '';
                realizarBusqueda(sugerencia.titulo);
            });
            suggestionsContainer.appendChild(sugerenciaElement);
        });
    }


    searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim().toLowerCase();
        if (query.length > 0) {
            const sugerencias = libros.filter(libro =>
                libro.titulo.toLowerCase().includes(query) ||
                libro.autor.toLowerCase().includes(query)
            ).slice(0, 5);
            mostrarSugerencias(sugerencias);
        } else {
            suggestionsContainer.innerHTML = '';
        }
    });


    document.addEventListener('click', (e) => {
        if (!suggestionsContainer.contains(e.target) && e.target !== searchInput) {
            suggestionsContainer.innerHTML = '';
        }
    });


    function realizarBusqueda(query) {
        loader.style.display = 'block';
        setTimeout(() => {
            loader.style.display = 'none';
            if (query) {
                const resultados = buscarLibros(query);
                if (resultados.length > 0) {
                    mostrarLibros(resultados, librosResultados);
                } else {
                    librosResultados.innerHTML = '<p>No se encontraron resultados.</p>';
                }
            } else {
                librosResultados.innerHTML = '<p>Por favor ingrese un término de búsqueda.</p>';
            }
        }, 1000);
    }


    searchButton.addEventListener('click', () => {
        realizarBusqueda(searchInput.value.trim());
    });


    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            realizarBusqueda(searchInput.value.trim());
        }
    });


    function verificarSesion(callback) {
        fetch('../php/check_session.php')
            .then(response => response.json())
            .then(data => {

                if (data.loggedIn) {
                    callback();
                } else {
                    alert('Debe iniciar sesión para realizar esta acción.');
                    window.location.href = 'login.html';
                }
            })
            .catch(error => {
                console.error('Error al verificar la sesión:', error);
                alert('Hubo un error al verificar su sesión. Por favor, inténtelo de nuevo.');
            });
    }


    function prestarLibro(libro) {
        fetch('../php/prestar_libro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            // Se asume que el objeto libro tiene una propiedad 'id' o similar
            body: JSON.stringify({
                libro_id: libro.id // Asegúrate de que tu objeto libro tenga un 'id'
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('El libro ha sido prestado con éxito.');
                    // Actualiza el estado local del libro
                    libro.disponible = false;
                    actualizarVistaLibro(libro);
                    // Oculta el panel después de prestar
                    panelInfo.style.display = 'none';
                } else {
                    alert('Hubo un error al prestar el libro: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al prestar el libro. Por favor, inténtelo de nuevo.');
            });
    }

    function actualizarVistaLibro(libro) {
        // Asumiendo que has añadido un atributo 'data-libro-id' a los elementos de la lista de libros
        const libroElement = document.querySelector(`[data-libro-id="${libro.titulo}"]`); 
        if (libroElement) {
            const estadoElement = libroElement.querySelector('.libro-estado');
            if (estadoElement) {
                estadoElement.textContent = libro.disponible ? 'Disponible' : 'No disponible';
                estadoElement.classList.toggle('No disponible', !libro.disponible);
            }
        }
        // Además, si el panel está abierto, actualiza el estado ahí también
        if (panelInfo.style.display === 'block') {
            mostrarPanelLibro(libro);
        }
    }


    // Función mostrarPanelLibro modificada
    function mostrarPanelLibro(libro) {
        panelInfo.innerHTML = `
            <div class="panel-content">
                <h2>${libro.titulo}</h2>
                <p><strong>Autor:</strong> ${libro.autor}</p>
                <p><strong>Fecha de publicación:</strong> ${libro.fecha}</p>
                <p><strong>Estado:</strong> <span class="libro-estado ${libro.disponible ? '' : 'No disponible'}">${libro.disponible ? 'Disponible' : 'No disponible'}</span></p>
                <div id="introduccion" style="display: none;">
                    <h3>Introducción</h3>
                    <p>${libro.introduccion}</p>
                </div>
                ${libro.disponible ? '<button id="prestar-libro">Prestar Libro</button>' : ''}
                <button id="previsualizar-libro">Previsualizar</button>
                <button id="cerrar-panel">Cerrar</button>
            </div>
        `;
        panelInfo.style.display = 'block';

        if (libro.disponible) {
            document.getElementById('prestar-libro').addEventListener('click', () => {
                verificarSesion(() => prestarLibro(libro));
            });
        }

        document.getElementById('cerrar-panel').addEventListener('click', () => {
            panelInfo.style.display = 'none';
        });

        // La función descargarPDF ya no está asociada a ningún botón visible
        // Si descargasPDF era el 'downloadButton' que quieres reemplazar totalmente:
        // document.getElementById('downloadButton').addEventListener('click', () => {
        //     verificarSesion(() => descargarPDF(libro));
        // });


        document.getElementById('previsualizar-libro').addEventListener('click', () => {
            const introduccion = document.getElementById('introduccion');
            if (introduccion.style.display === 'none') {
                introduccion.style.display = 'block';
                document.getElementById('previsualizar-libro').textContent = 'Ocultar previsualización';
            } else {
                introduccion.style.display = 'none';
                document.getElementById('previsualizar-libro').textContent = 'Previsualizar';
            }
        });
    }

    // La función descargarPDF se mantiene pero ya no es llamada por un botón.
    function descargarPDF(libro) {
        const tituloFormateado = libro.titulo.replace(/\s+/g, '_').toLowerCase();
        const urlPDF = `../pdfs/${tituloFormateado}.pdf`;


        fetch(urlPDF)
            .then(response => {
                if (response.ok) {
                    return response.blob();
                }
                throw new Error('El PDF no está disponible.');
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = `${libro.titulo}.pdf`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            })
            .catch(error => {
                console.error('Error al descargar el PDF:', error);
                alert('Lo sentimos, no se pudo descargar el PDF. Por favor, inténtelo de nuevo más tarde.');
            });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const userMenu = document.querySelector(".user-menu");
    const userIcon = document.getElementById("userIcon");

    userIcon.addEventListener("click", () => {
        userMenu.classList.toggle("active");
    });

    document.addEventListener("click", (e) => {
        if (!userMenu.contains(e.target)) {
            userMenu.classList.remove("active");
        }
    });
});