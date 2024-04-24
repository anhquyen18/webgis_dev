from swmm_api import read_inp_file, read_out_file,read_rpt_file, SwmmInput
from swmm_api.input_file.section_labels import *
import sys
import json
from datetime import date, time

def main():
   
    # input_data = json.loads(sys.argv[1])

    # Xử lý dữ liệu (ví dụ: đảo ngược chuỗi)
    # output_data = {"result": input_data[::-1]}
    
    return json.loads(sys.argv[1])['world']
    # return output_data
    # return 'anhquyen'

    # Trả kết quả về PHP dưới dạng JSON
    # print(json.dumps(output_data))





if __name__ == "__main__":
    print(main())
    # main()
    