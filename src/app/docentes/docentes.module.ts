import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TableModule } from 'primeng/table';

import { DocentesRoutingModule } from './docentes-routing.module';
import { DocentesMainComponent } from './docentes-main/docentes-main.component';
import { DocentesNavComponent } from './docentes-nav/docentes-nav.component';
import { DocentesMeetingListComponent } from './docentes-meeting-list/docentes-meeting-list.component';
import { DocentesMeetingProcessComponent } from './docentes-meeting-process/docentes-meeting-process.component';


@NgModule({
  declarations: [DocentesMainComponent, DocentesNavComponent, DocentesMeetingListComponent, DocentesMeetingProcessComponent],
  imports: [
    CommonModule,
    DocentesRoutingModule,
    TableModule
  ]
})
export class DocentesModule { }
