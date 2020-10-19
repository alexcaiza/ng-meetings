import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { EstudiantesMainComponent } from './estudiantes-main/estudiantes-main.component';
import { EstudiantesMeetingListComponent } from './estudiantes-meeting-list/estudiantes-meeting-list.component';
import { EstudiantesMeetingRegisterComponent } from './estudiantes-meeting-register/estudiantes-meeting-register.component';

const routes: Routes = [
  {
    path: '',
    component: EstudiantesMainComponent,
    children: [
      { path: 'estudiantes-meeting-list', component: EstudiantesMeetingListComponent },
      { path: 'estudiantes-meeting-register', component: EstudiantesMeetingRegisterComponent },
    ]
  }  
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class EstudiantesRoutingModule { }
