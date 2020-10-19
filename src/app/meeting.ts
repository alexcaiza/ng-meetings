import { Estudiante } from './estudiante';
import { Horario } from './horario';
import { Profesor } from './profesor';

export class Meeting {
    meetingid: number;
    fechameeting: Date;    
    fecharegistro: Date;
    stutus: string;
    estado: string;    
    profesor: Profesor;
    estudiante: Estudiante;
    hora: Horario;
}
