<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; margin: 0; }
        .container { display: flex; justify-content: center; align-items: center; height: 100vh; }
        .about-box { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 12px; display: flex; max-width: 800px; width: 100%; overflow: hidden; }
        .about-image { flex: 1; display: flex; align-items: center; justify-content: center; background: #e5e7eb; }
        .about-image img { max-width: 250px; max-height: 350px; border-radius: 8px; }
        .about-info { flex: 2; padding: 32px; display: flex; flex-direction: column; justify-content: center; }
        .about-info h2 { margin-top: 0; color: #1e293b; }
        .about-info p { color: #334155; line-height: 1.6; }
        .about-info ul { margin: 16px 0 0 0; padding: 0 0 0 18px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="about-box">
            <div class="about-image">
                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Foto de perfil">
            </div>
            <div class="about-info">
                <h2>Sobre Nosotros</h2>
                <p><strong>Juan Pérez</strong><br>Desarrollador Full Stack con más de 5 años de experiencia en tecnologías web y móviles. Apasionado por la innovación y el aprendizaje continuo.</p>
                <ul>
                    <li>Ingeniero en Informática</li>
                    <li>Especialista en Laravel, Vue.js y React</li>
                    <li>Experiencia en proyectos internacionales</li>
                    <li>Idiomas: Español, Inglés</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
