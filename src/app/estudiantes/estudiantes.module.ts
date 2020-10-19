import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { EstudiantesRoutingModule } from './estudiantes-routing.module';
import { EstudiantesMainComponent } from './estudiantes-main/estudiantes-main.component';
import { EstudiantesNavComponent } from './estudiantes-nav/estudiantes-nav.component';
import { EstudiantesMeetingListComponent } from './estudiantes-meeting-list/estudiantes-meeting-list.component';
import { EstudiantesMeetingRegisterComponent } from './estudiantes-meeting-register/estudiantes-meeting-register.component';

import {FormsModule,ReactiveFormsModule } from '@angular/forms'; 
import { HttpClientModule } from '@angular/common/http';

@NgModule({
  declarations: [
    EstudiantesMainComponent, 
    EstudiantesNavComponent, 
    EstudiantesMeetingListComponent, 
    EstudiantesMeetingRegisterComponent
  ],
  imports: [
    CommonModule,
    EstudiantesRoutingModule,
    FormsModule,
    HttpClientModule,
    ReactiveFormsModule,
  ]
})
export class EstudiantesModule { }
