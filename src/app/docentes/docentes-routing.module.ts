import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DocentesMainComponent } from './docentes-main/docentes-main.component';
import { DocentesMeetingListComponent } from './docentes-meeting-list/docentes-meeting-list.component';
import { DocentesMeetingProcessComponent } from './docentes-meeting-process/docentes-meeting-process.component';

const routes: Routes = [
  {
    path: '',
    component: DocentesMainComponent,
    children: [
      { path: 'docentes-meeting-list', component: DocentesMeetingListComponent },
      { path: 'docentes-meeting-register', component: DocentesMeetingProcessComponent },
    ]
  }  
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class DocentesRoutingModule { }
