import { Catalogo } from './catalogo';
import { Estudiante } from './estudiante';
import { Horario } from './horario';
import { MeetingEnginieStatus } from './meetingenginiestatus';
import { Profesor } from './profesor';

export class Meeting {
    meetingid: number;
    meetingsstatusid: number;
    fechameeting: Date;    
    fecharegistro: Date;
    meetingstatuscode: number;
    meetingstatusvalue: string;
    meetingstatusname: string;
    estado: string;    
    profesor: Profesor;
    estudiante: Estudiante;
    hora: Horario;
    estadoanterior: Catalogo;
    estadoactual: Catalogo;
    
    meetingAction: Catalogo;

    meetingEnginieStatus: MeetingEnginieStatus;

    observacion: string;
    meetingurl: string;

    constructor() {
        this.meetingid = null;
        this.meetingsstatusid = null;
        this.fechameeting = null;
        this.fecharegistro = null;        
        this.estado = null;
        this.profesor = null;
        this.estudiante = null;
        this.hora = null;
        this.estadoanterior = null;
        this.estadoactual = null;
        this.meetingAction = null;        
        this.meetingEnginieStatus = null;
        this.observacion = null;
        this.meetingurl = null;
        this.meetingstatuscode = null;
        this.meetingstatusvalue = null;
        this.meetingstatusname = null;
    }
}
