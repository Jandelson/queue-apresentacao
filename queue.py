from sqlalchemy import create_engine
import pandas as pd

list_data_frames = []
table = {
    "sql_query": ["select * from seedtag"],
}
df = pd.DataFrame(table)
list_data_frames.append(df)

engine = create_engine('mysql://root:root@localhost:3311/app')
union = pd.concat(list_data_frames, ignore_index=True, sort=False)
union.to_sql('queue', con=engine, if_exists='append', index=False)