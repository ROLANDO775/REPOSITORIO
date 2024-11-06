<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <title>ALCALDIA SAS</title>
    <style>
        .slideshow-container {
            position: relative;
        }

        .prin {
            display: none;
            width: 100%; /* Ajusta según sea necesario */
        }

        .prin.active {
            display: block;
        }
    </style>
</head>
<body>
    <header>
        <a href="php/inicio.php" class="logo">
            <img src="image/alcaldia.png" alt="logo de la compa" class="logo-img">
            <h2 class="alcaldia">ALCALDIA COMUNITARIA</h2>
        </a>
        <input type="checkbox" id="menu">
        <label for="menu">
            <img src="image/menu.png" alt="Menú" class="menu-icono">
        </label>
        <nav>
            <a href="php/registro.php"   class="nav-link">REGISTRO</a>
            <a href="php/niños.php"      class="nav-link">INCRIPCION DE NIÑOS</a>
            <a href="php/pagos.php"      class="nav-link">PAGOS</a>
            <a href="php/difuncion.php"  class="nav-link">REGISTRO DE DEFUNCION</a>
        </nav>
    </header>
    <main>
        <section class="principal">
            <div class="slideshow-container">
                <img src="image/san3.jpg" alt="" class="prin active">
                <img src="image/san2.jpg" alt="" class="prin">
                <img src="image/san4.jpg" alt="" class="prin">
            </div>
            <h2>QUIENES SOMOS</h2>
            <p>La alcaldía comunitaria es una institución indígena de máxima autoridad, es electa cada año por la comunidad en forma de voz y voto, toman posesión el 1 de enero, deben ser personas con una trayectoria de servicios comunitaria o social, con una moral y ética intachable en la comunidad. Vivimos y caminamos bajo la guía espiritual de nuestros abuelos y abuelas, buscando siempre y a través de nuestro servicio y nuestro compromiso, una vida mejor para la comunidad San Antonio Sija.</p>
        </section>
        <section class="secundario">
            <h2>MISION</h2>
            <p>Trabajamos por la autonomía, para asumir de forma conjunta, la responsabilidad, el trabajo y el servicio por el desarrollo de los hombres y las mujeres de los 34 parajes de la comunidad de San Antonio Sija, Denunciamos las injusticias, así como todas las acciones, leyes y políticas que violan o destruyen la dignidad humana, los derechos y la vida de los pueblos indígenas, de las mujeres, de la niñez, de la juventud y los bienes naturales. Somos el ente encargado de coordinar, definir, supervisar, proteger y brindar apoyo a las familias en donde surgen conflictos: tales como desintegración familiar u otros.</p>
            <img src="image/feria1.jpg" alt="amigos" class="carrerani">
        </section>
        <section class="secundario">
            <h2>VISION</h2>
            <p>Ser la expresión de la voluntad, la vocación de servicio y el espíritu solidario de la población, siempre bajo la guía espiritual de nuestros abuelos y abuelas, manteniendo siempre vivo nuestro sistema ancestral de autoridades, tener lideres con capacidades, que participan de forma activa y sostenida con la población que busca el desarrollo de la comunidad</p>
            <img src="image/sanantonio.jpg" alt="ambiente" class="ambientesi">
        </section>
        <section class="secundario">
            <h2>TIERRA DE LOS GRANDES EVENTOS</h2>
            <iframe src="https://www.youtube.com/embed/UTVqaTtUa2U" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <iframe src="https://www.youtube.com/embed/RXfiEOcggWg" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <iframe src="https://www.youtube.com/embed/VArSmmPcY4c" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>      
        </section>
        <section class="secundario">
            <div class="fila">
                <div>
                    <h2>OBJETIVOS GENERALES</h2>
                    <p>1. Defender colectivamente la vida, la dignidad y los derechos de las familias, de las comunidades, del pueblo y de la madre naturaleza, que es la que nos cobija y da la vida…. Siempre respetar, valorar y seguir las enseñanzas y los caminos trazados por las abuelas y los abuelos.</p>
                    <p>2. Formar jóvenes con aprendizajes significativos, felices, sanos y seguros de sí mismos, con proyección a una educación superior, con una participación activa de todos sus habitantes sin que nadie los limite.</p>
                    <p>3. Promover nuestra cultura y tradiciones en diferentes ámbitos de la vida.</p>
                </div>
            </div>
        </section>
        <section class="secundario">
            <div class="fila">
                <div>
                    <h2>PROPÓSITOS</h2>
                    <p>1. Promover el mejoramiento de la calidad educativa.</p>
                    <p>2. Promover y apoyar los diferentes comités de la comunidad.</p>
                    <p>3. Promover y apoyar a las diferentes organizaciones no gubernamentales que existen en la comunidad.</p>
                    <p>4. Cuidar que los edificios públicos, puentes y caminos vecinales se mantengan en buen estado.</p>
                </div>
            </div>
        </section>
        <section class="contacto">
            <h2>C O N T A C T A N O S</h2>
            <ul class="redes">
                <li>
                    <a href="https://api.whatsapp.com/send?phone=37426796&text=Alcaldía Comunitaria De San Antonio Sija" target="_blank">
                        <i class="fa-brands fa-whatsapp"></i>   WhatsApp
                    </a>
                </li>
                <li>
                    <a href="https://www.facebook.com/profile.php?id=100092182701405" target="_blank">
                        <i class="fa-brands fa-facebook"></i>   Facebook
                    </a>
                </li>
            </ul>
        </section>
        <section class="direccion">
            <h2>D I R E C C I O N</h2>
            <ul class="dire">
                <li>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3854.2659729643483!2d-91.52894247364692!3d14.977933679198818!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x858e9f7557a5f699%3A0xe24c55d0da288950!2sSan%20Antonio%20Sija!5e0!3m2!1ses-419!2sgt!4v1726011409683!5m2!1ses-419!2sgt" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </li>
            </ul>
        </section>
    </main>
    <script>
        let currentIndex = 0;
        const images = document.querySelectorAll('.prin');

        function showNextImage() {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].classList.add('active');
        }

        setInterval(showNextImage, 5000); // Cambia cada 5 segundos
    </script>
</body>
</html>
