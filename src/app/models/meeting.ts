import { Catalogo } from './catalogo';
import { Estudiante } from './estudiante';
import { Horario } from './horario';
import { Profesor } from './profesor';

export class Meeting {
    meetingid: number;
    fechameeting: Date;    
    fecharegistro: Date;
    status: string;
    estado: string;    
    profesor: Profesor;
    estudiante: Estudiante;
    hora: Horario;
    estadoanterior: Catalogo;
    estadoactual: Catalogo;
    observacion: string;
    meetingurl: string;

    constructor() {
        this.meetingid = null;
        this.fechameeting = null;
        this.fecharegistro = null;
        this.status = null;
        this.estado = null;
        this.profesor = null;
        this.estudiante = null;
        this.hora = null;
        this.estadoanterior = null;
        this.estadoactual = null;
        this.observacion = null;
        this.meetingurl = null;
    }
}
