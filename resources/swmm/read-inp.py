from swmm_api import read_inp_file, read_out_file,read_rpt_file, SwmmInput
from swmm_api.input_file.section_labels import *
import sys
import json
from datetime import date, time

def main():
    inp = read_inp_file('F:/Water Resource/SWMM/first-sample-project.inp')  # type: swmm_api.SwmmInput
 
    data = '{'

    # print(inp._original_section_order)
    for index, item in enumerate(inp._original_section_order):
        if item == 'RAINGAGES':
            continue
        if hasattr(inp, item): 
            typeOfObject = str(type(getattr(inp, item)))
            if typeOfObject == "<class 'NoneType'>":
                data += '"' + item + '":'+ '"None",'
            elif typeOfObject == "<class 'swmm_api.input_file.helpers.InpSection'>":
                if len(getattr(inp, item)) > 0:
                    sectionJson = '"' + item + '":{'
                    for attribute, value in vars(getattr(inp, item)).items():
                        if attribute == '_data':
                            for key in value.keys():
                                if isinstance(key, tuple):
                                    objectJson = '"'+'-'.join(key)+'":{'
                                else:
                                    objectJson = '"'+key+'":{'
                                for index, section in  enumerate(value[key].attributes):
                                    if type(value[key].values[index]) is dict:
                                        smallObjectJson = '{'
                                        for smallKey, smallValue in value[key].values[index].items():
                                            smallObjectJson += '"'+smallKey+'":'+'"'+str(smallValue)+'",'
                                        smallObjectJson = smallObjectJson[:-1]
                                        smallObjectJson += '}'
                                        objectJson += '"'+ value[key].attributes[index]+'":'+ smallObjectJson + ','
                                    else:
                                        objectJson += '"'+ value[key].attributes[index]+'":'+ '"'+str(value[key].values[index])+'",'
                                objectJson = objectJson[:-1]
                                objectJson += '},'
                                sectionJson  += objectJson
                            sectionJson  += '}'
                            sectionJson  = sectionJson [:-2] + sectionJson [-1] + ','

                    data += sectionJson
                elif len(getattr(inp, item)) == 0: 
                    data += '"' + item + '":'+ '"None",'
            elif str(typeOfObject).startswith("<class 'swmm_api.input_file.sections.generic_section"):
                sectionJson = '"' + item + '":{'
                for attribute, value in vars(getattr(inp,item)).items():
                    if attribute == '_data' or attribute == '_inp':
                        continue
                    sectionJson += '"' + attribute + '":"' + str(value) + '",'
                sectionJson = sectionJson[:-1]
                sectionJson += '},'
                data += sectionJson
                    


    data += '}'
 
    data = data[:-2] + data[-1]
    # data = data[:-2] + data[-1]
    data = data.replace("\\","/")
    # data = data.replace('\"', '\'')
    # return vars(getattr(inp,'OPTIONS')).items()._data
    return data
    for attribute, value in vars(getattr(inp,'OPTIONS')).items():
        if attribute == '_data' or attribute == '_inp':
            continue
        print(attribute)

    # for attribute, value in vars(getattr(inp, 'BUILDUP')).items():
    #     # if attribute == '_inp' or attribute == '_data':
    #     #     continue
    #     junctionJson = '"JUNCTION":{'
    #     if attribute == '_data':
    #         # print(type(getattr(inp, 'WASHOFF')))
    #         # print(f"{attribute}: {value}")
    #         # print(value)
    #         for key in value.keys():
    #             # print(item)
    #             # print(value[item].attributes)
    #             if isinstance(key, tuple):
    #                 sectionJson = '"'+'-'.join(key)+'":{'
    #             else:
    #                 sectionJson = '"'+key+'":{'
    #             for index, section in  enumerate(value[key].attributes):
    #                 sectionJson += '"'+ value[key].attributes[index]+'":'+ '"'+str(value[key].values[index])+'",'
    #             sectionJson = sectionJson[:-1]
    #             sectionJson += '},'
    #             #  sectionJson = sectionJson[:-2] + sectionJson[-1]
    #             junctionJson += sectionJson 
    #             # junctionJson += ',}'
    #         junctionJson += '}'
    #         junctionJson = junctionJson[:-2] + junctionJson[-1] + ','

    #         # newstring = junctionJson.rstrip(',')
    #         print(junctionJson)
            # print(value.keys())
            # print(value['J1'].attributes)
            # print(value['J1'].values)
            # print(value['FLOW_UNITS'])





if __name__ == "__main__":
    print(main())
    # main()
    # Giờ chuyển mấy cái như JUNCTION được rồi, giờ tính mấy cái class như Options...
    # Thử đọc file này rồi vẽ lên trên map theo openlayers?
    