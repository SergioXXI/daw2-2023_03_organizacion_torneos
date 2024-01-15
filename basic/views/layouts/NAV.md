GENERAL - Inicio (todos)

GRUPO 1 - 
    -> Registro [/user/register] -> Invitado y gestor
    -> Login [/site/login] -> Invitado
    -> Logout [/site/logout] -> Todos menos Invitado
    -> Roles [/auth-item] -> sysadmin 
    <- Usuarios [/user] -> sysadmin, admin
    -> Perfil [/user/view-profile/] -> Todos menos Invitado

GRUPO 2 -
    <- Torneos [/torneo/index] -> Todos *
    <- Reservas [/reserva/index] -> sysadmin, admin, organizador, gestor
    <- Disciplina [/disciplinas/index] -> sysadmin, admin
    <- Categoria [/categoria/index] -> sysadmin, admin
    <- Clase [/clase/index] -> sysadmin, admin
    <- Tipo torneo [/tipo-torneo/index] -> sysadmin, admin
    <- Premios ['premio/index'] -> sysadmin, admin, organizador

GRUPO 3 - 
    <- Equipos ['/equipo/index'] -> nose
    <- Equipos (gestion) ['/equipo/index'] => sysadmin, admin
    <- Participantes ['participante/index'] => nose
    <- Participantes (gestion) ['participante/index'] => sysadmin, admin

GRUPO 4 - 
    <- Pistas ['pista/pistas'] -> todos *
    <- Pistas ['pista/index'] -> sysadmin, admin
    <- Direccion ['direccion/index] -> sysadmin, admin
    <- Calendario ['calendario/index] -> todos *
    <- Backup ['backup/index'] -> sysadmin, admin
    <- Logs ['log/index'] -> sysadmin, admin 