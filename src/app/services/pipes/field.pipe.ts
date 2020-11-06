import { Pipe, PipeTransform } from '@angular/core';
@Pipe({
  name: 'field'
})
export class FieldPipe implements PipeTransform {
  /**
   *
   */
  constructor() {}
  transform(value: any, ...args: any[]): any {
    const column: any = args[0];
    let result = value;
    let cont = 0;
    let level = 0;
    let temp = '';

    column.field.split('.').forEach(f => {
      const valueColumn = result[f];
      if (undefined !== valueColumn) {
        result = valueColumn;
      } else {
        if (cont === level) {
          value[f] = '0';
          temp = f;
          result = '0';
        } else {
          if (cont > level) {
            const jsonTemp: any = {} ;
            jsonTemp[f] = '';
            value[temp] = jsonTemp;
            result = '';
          }
        }
        level = cont;
      }
      cont ++;
    });
    return result;
  }
}
