from swmm_api import read_inp_file, read_out_file,read_rpt_file, SwmmInput
from swmm_api import swmm5_run
import sys
import json

def main():
    inp = read_inp_file('F:/Water Resource/SWMM/first-sample-project.inp')  # type: swmm_api.SwmmInput
    out = read_out_file('F:/Water Resource/SWMM/first-sample-project.out')
    df = out.to_frame() 
    np = out.to_numpy() 
    rpt = read_rpt_file('F:/Water Resource/SWMM/first-sample-project.rpt')  # type: swmm_api.SwmmReport
    # node_flooding_summary = rpt.node_flooding_summary  # type: pandas.DataFrame
    # or 
    # inp = SwmmInput.read_file('inputfile.inp')
    # or
    # inp = SwmmInput('inputfile.inp')
    # print('anhquyendeptraivcl')
    # print(node_flooding_summary)
    # swmm5_run('F:/Water Resource/SWMM/first-sample-project.inp', 'C:/rogram Files/EPA SWMM 5.2.4 (64-bit)/runswmm.exe')
    # swmm5_run('F:/Water Resource/SWMM/first-sample-project.inp', progress_size=100, swmm_lib_path='C:/rogram Files/EPA SWMM 5.2.4 (64-bit)/runswmm.exe')
    # print(inp.SUBCATCHMENTS['S1'])
    # inp.SUBCATCHMENTS['S1'].width = 500.0
    # inp.write_file('F:/Water Resource/SWMM/first-sample-project.inp')
    # print(type(rpt.subcatchment_runoff_summary))
    data = rpt.subcatchment_runoff_summary.to_json()
    # data = rpt.subcatchment_runoff_summary.to_json(orient='records', lines=True)
    # print(data)
    # print(type(data))
    # Nhận dữ liệu từ tham số dòng lệnh
    data_from_php = sys.argv[1]

    # Xử lý dữ liệu và trả về kết quả (ví dụ: JSON)
    response_data = {'message': f'Hello from Python! Received data: {data_from_php}'}
    print(json.dumps(response_data))

    # return data
    # return data


if __name__ == "__main__":
    # print(main())
    main()
    