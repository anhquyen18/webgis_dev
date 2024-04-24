from swmm_api import *
from swmm_api.output_file.definitions import * 

import sys
import json

def main():
    rpt = SwmmReport('F:/Water Resource/SWMM/first-sample-project.rpt')
    summaryList = ['subcatchment_runoff_summary', 'subcatchment_washoff_summary', 'node_depth_summary', 'node_inflow_summary','outfall_loading_summary', 'link_flow_summary', 'link_pollutant_load_summary' ]
    summaryJson = '{'
    for summary in summaryList:
        summaryJson += '"' + summary + '":' + getattr(rpt,summary).to_json(orient="index") + ','
    # return rpt['subcatchment_runoff_summary']
    summaryJson += '}'
    summaryJson = summaryJson[:-2] + summaryJson[-1]
    return summaryJson





if __name__ == "__main__":
    print(main())
    # main()
    